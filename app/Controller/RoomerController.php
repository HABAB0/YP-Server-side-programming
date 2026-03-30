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
            $data['status'] = 'В ожидании';

            $validator = new Validator($oldInput, [
                'fio' => ['required'],
                'passport_series' => ['required', 'numeric', 'unique:roomer,passport_series'],
                'passport_number' => ['required', 'numeric', 'unique:roomer,passport_number'],
                'number_of_check_in' => ['required', 'numeric', 'unique:roomer,number_of_check_in'],

            ], [
                'required' => 'Поле :field пусто',
                'numeric' => 'Поле :field должно быть числом',
                'unique' => 'Поле :field должно быть уникально'
            ]);


            if($validator->fails()){
                return new View('site.roomer.create',[
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
            'old' => [],
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
            return (new View())->render('site.roomer.edit', [
                'roomer' => $roomer,
                'old' => []
            ]);
        }

        if ($request->method === 'POST') {
            $oldInput = $request->all();
            unset($oldInput['csrf_token']);

            $validator = new Validator($oldInput, [
                'fio' => ['required'],
                'passport_series' => ['required', 'numeric'],
                'passport_number' => ['required', 'numeric'],
                'number_of_check_in' => ['required', 'numeric'],
                'status' => ['required']
            ], [
                'required' => 'Поле :field пусто',
                'numeric' => 'Поле :field должно быть числом',
            ]);

            if ($validator->fails()) {
                return (new View())->render('site.roomer.edit', [
                    'roomer' => Roomer::find($id),
                    'old' => $oldInput,
                    'message' => json_encode($validator->errors(), JSON_UNESCAPED_UNICODE)
                ]);
            }

            $roomer = Roomer::find($id);
            if ($roomer) {
                $roomer->fio = $oldInput['fio'];
                $roomer->passport_series = $oldInput['passport_series'];
                $roomer->passport_number = $oldInput['passport_number'];
                $roomer->number_of_check_in = $oldInput['number_of_check_in'];
                $roomer->status = $oldInput['status'];
                $roomer->save();
            }

            app()->route->redirect('/roomers');
            exit;
        }

        return (new View('errors.forbidden'))->render();
    }
}