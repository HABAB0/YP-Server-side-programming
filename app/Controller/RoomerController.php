<?php

namespace Controller;

use Model\Building;
use Model\Roomer;
use Src\Request;
use Src\Validator\Validator;
use Src\View;

class RoomerController
{
    public function roomers(): string
    {
        $roomers = Roomer::all();
        return (new View())->render('site.roomer.roomers', ['roomers' => $roomers]);
    }

    public function roomerCreate(Request $request): string
    {

        $user = app()->auth->user();
        if (!$user || $user->role_id !== 1) {
            app()->route->redirect('/forbidden');
            exit;
        }

        $roomer = Roomer::all();

        if ($request->method === 'POST') {
            $oldInput = $request->all();
            $data['status'] = $data['status'] ?? 'active';

            $validator = new Validator($oldInput, [
                'fio' => ['required'],
                'passport_series' => ['required', 'numeric'],
                'passport_number' => ['required', 'numeric'],

            ], [
                'required' => 'Поле :field пусто',
                'numeric' => 'Поле :field должно быть числом'
            ]);

            if($validator->fails()){
                return (new View())->render('site.roomer.create', [
                    'old' => $oldInput,
                    'message' => json_encode($validator->errors(), JSON_UNESCAPED_UNICODE)
                ]);
            }

            $data = $request->all();

            Roomer::create($data);

            app()->route->redirect('/roomers');
            exit;
        }
        return (new View())->render('site.roomer.create', [
            'old' => []
        ]);
    }

    public function roomerDelete(int $id): void
    {
        $building = Roomer::find($id);

        if ($building) {
            $building->delete();
        }

        app()->route->redirect('/roomers');
        exit;
    }

    public function roomerEdit(int $id, Request $request): string
    {
        $user = app()->auth->user();
        if (!$user || $user->role_id !== 1) {
            app()->route->redirect('/forbidden');
            exit;
        }

        if ($request->method === 'GET') {
            $roomer = Roomer::find($id);
            return (new View())->render('site.roomers.edit', [
                'roomer' => $roomer,
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
                return (new View())->render('site.roomers.edit', [
                    'room' => Roomer::find($id),
                    'buildings' => Building::all(),
                    'old' => $oldInput,
                    'message' => json_encode($validator->errors(), JSON_UNESCAPED_UNICODE)
                ]);
            }

            $room = Roomer::find($id);
            if ($room) {
                $room->building_id = $oldInput['building_id'];
                $room->room_number = $oldInput['room_number'];
                $room->capacity = $oldInput['capacity'];
                $room->type = $oldInput['type'];
                $room->save();
            }

            app()->route->redirect('/roomers');
            exit;
        }

        return (new View('errors.forbidden'))->render();
    }
}