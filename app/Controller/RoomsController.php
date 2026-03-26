<?php

namespace Controller;

use Model\Room;
use Src\Request;
use Src\Validator\Validator;
use Src\View;

class RoomsController
{
    public function rooms(): string
    {
        $rooms = Room::all();
        return (new View())->render('site.rooms.rooms', ['rooms' => $rooms]);
    }

    public function roomCreate(Request $request): string
    {

        $user = app()->auth->user();
        if (!$user || $user->role_id !== 1) {
            app()->route->redirect('/forbidden');
            exit;
        }

        if ($request->method === 'POST') {

            $validator = new Validator($request->all(), [
                'room_number' => ['required'],
                'capacity' => ['required']
            ], [
                'required' => 'Поле :field пусто',
            ]);

            if($validator->fails()){
                return new View('site.rooms.create',
                    ['message' => json_encode($validator->errors(), JSON_UNESCAPED_UNICODE)]);
            }
            $data = $request->all();

            Room::create($data);

            app()->route->redirect('/rooms');
            exit;
        }
        return new View('site.rooms.create');
    }

    public function roomDelete(int $id): void
    {
        $building = Room::find($id);

        if ($building) {
            $building->delete();
        }

        app()->route->redirect('/rooms');
        exit;
    }

    public function edit(int $id): string
    {
        $room = Room::find($id);
        return (new View())->render('site.rooms.edit', ['room' => $room]);
    }

    public function roomUpdate(int $id, Request $request): void
    {
        $room = Room::find($id);

        if ($room) {
            $data = $request->all();

            $room->room_number = $data['room_number'];
            $room->capacity = $data['capacity'];
            $room->type = $data['type'];
            $room->fullness = $data['fullness'];
            $room->save();
        }

        app()->route->redirect('/rooms');
        exit;
    }
}