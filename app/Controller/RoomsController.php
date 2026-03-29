<?php

namespace Controller;

use Model\Building;
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

        $buildings = Building::all();

        if ($request->method === 'POST') {
            $oldInput = $request->all();

            $validator = new Validator($oldInput, [
                'building_id' => ['required'],
                'room_number' => ['required'],
                'capacity' => ['required', 'numeric'],
                'type' => ['required']
            ], [
                'required' => 'Поле :field пусто',
                'numeric' => 'Поле :field должно быть числом'
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
        return new View('site.rooms.create', [
            'buildings' => $buildings,
            'old' => [],
            'message' => null
        ]);
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

    public function roomEdit(int $id, Request $request): string
    {
        $user = app()->auth->user();
        if (!$user || $user->role_id !== 1) {
            app()->route->redirect('/forbidden');
            exit;
        }

        if ($request->method === 'GET') {
            $room = Room::find($id);
            return (new View())->render('site.rooms.edit', [
                'room' => $room,
                'buildings' => Building::all(),
                'old' => []
            ]);
        }

        if ($request->method === 'POST') {
            $oldInput = $request->all();
            unset($oldInput['csrf_token']);

            $validator = new Validator($oldInput, [
                'building_id' => ['required'],
                'room_number' => ['required'],
                'capacity' => ['required', 'numeric'],
                'type' => ['required']
            ], [
                'required' => 'Поле :field пусто',
                'numeric' => 'Поле :field должно быть числом'
            ]);

            if ($validator->fails()) {
                return (new View())->render('site.rooms.edit', [
                    'room' => Room::find($id),
                    'buildings' => Building::all(),
                    'old' => $oldInput,
                    'message' => json_encode($validator->errors(), JSON_UNESCAPED_UNICODE)
                ]);
            }

            $room = Room::find($id);
            if ($room) {
                $room->building_id = $oldInput['building_id'];
                $room->room_number = $oldInput['room_number'];
                $room->capacity = $oldInput['capacity'];
                $room->type = $oldInput['type'];
                $room->save();
            }

            app()->route->redirect('/rooms');
            exit;
        }

        return (new View('errors.forbidden'))->render();
    }
}