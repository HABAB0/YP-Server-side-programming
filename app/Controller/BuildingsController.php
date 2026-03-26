<?php

namespace Controller;

use Model\Building;
use Src\Request;
use Src\Validator\Validator;
use Src\View;

class BuildingsController
{
    public function buildings(): string
    {
        $buildings = Building::all();
        return (new View())->render('site.buildings.buildings', ['buildings' => $buildings]);
    }

    public function create(Request $request): string
    {

        $user = app()->auth->user();
        if (!$user || $user->role_id !== 1) {
            app()->route->redirect('/forbidden');
            exit;
        }

        if ($request->method === 'POST') {

            $validator = new Validator($request->all(), [
                'name' => ['required'],
                'address' => ['required']
            ], [
                'required' => 'Поле :field пусто',
            ]);

            if($validator->fails()){
                return new View('site.buildings.create',
                    ['message' => json_encode($validator->errors(), JSON_UNESCAPED_UNICODE)]);
            }
            $data = $request->all();

            Building::create($data);

            app()->route->redirect('/buildings');
            exit;
        }
        return new View('site.buildings.create');
    }

    public function delete(int $id): void
    {
        $building = Building::find($id);

        if ($building) {
            $building->delete();
        }

        app()->route->redirect('/buildings');
        exit;
    }

    public function edit(int $id): string
    {
        $building = Building::find($id);
        return (new View())->render('site.buildings.edit', ['building' => $building]);
    }

    public function update(int $id, Request $request): void
    {
        $building = Building::find($id);

        if ($building) {
            $data = $request->all();

            $building->name = $data['name'];
            $building->address = $data['address'];
            $building->save();
        }

        app()->route->redirect('/buildings');
        exit;
    }
}