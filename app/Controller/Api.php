<?php

namespace Controller;

use Model\Building;
use Model\Roomer;
use Src\Auth\Auth;
use Src\Request;
use Src\Validator\Validator;
use Src\View;

class Api
{
    public function index(): void
    {
        $roomer = Roomer::all()->toArray();

        (new View())->toJSON($roomer);
    }

    public function echo(Request $request): void
    {
        (new View())->toJSON($request->all());
    }

    public function auth(Request $request): void
    {
        $data = $request->all();
        $credentials = [
            'login' => $data['login'] ?? '',
            'password' => $data['password'] ?? '',
        ];

        if (empty($credentials['login']) || empty($credentials['password'])) {
            (new View())->toJSON(['error' => 'Укажите login и password'], 400);
        }

        $token = Auth::issueApiToken($credentials);

        if ($token === null) {
            (new View())->toJSON(['error' => 'Неверные логин или пароль'], 401);
        }

        (new View())->toJSON(['token' => $token]);
    }

    public function buildings(): void
    {
        (new View())->toJSON(['buildings' => Building::all()->toArray()]);
    }

    public function building(int $id): void
    {
        $building = Building::find($id);

        if (!$building) {
            (new View())->toJSON(['error' => 'Здание не найдено'], 404);
        }

        (new View())->toJSON(['building' => $building->toArray()]);
    }

    public function createBuilding(Request $request): void
    {
        $this->requireAdmin();

        $data = $this->validateBuilding($request);

        $building = Building::create([
            'name' => $data['name'],
            'address' => $data['address'],
            'image_path' => $data['image_path'] ?? null,
        ]);

        (new View())->toJSON(['building' => $building->toArray()], 201);
    }

    public function updateBuilding(int $id, Request $request): void
    {
        $this->requireAdmin();

        $building = Building::find($id);

        if (!$building) {
            (new View())->toJSON(['error' => 'Здание не найдено'], 404);
        }

        $data = $this->validateBuilding($request);

        $building->name = $data['name'];
        $building->address = $data['address'];
        if (array_key_exists('image_path', $data)) {
            $building->image_path = $data['image_path'];
        }
        $building->save();

        (new View())->toJSON(['building' => $building->toArray()]);
    }

    public function deleteBuilding(int $id): void
    {
        $this->requireAdmin();

        $building = Building::find($id);

        if (!$building) {
            (new View())->toJSON(['error' => 'Здание не найдено'], 404);
        }

        if (!empty($building->image_path)) {
            $filePath = __DIR__ . '/../../public' . $building->image_path;
            if (is_file($filePath)) {
                unlink($filePath);
            }
        }

        $building->delete();

        (new View())->toJSON(['message' => 'Здание удалено']);
    }

    private function requireAdmin(): void
    {
        $user = Auth::user();
        if (!$user || $user->role_id !== 1) {
            (new View())->toJSON(['error' => 'Доступ запрещён'], 403);
        }
    }

    private function validateBuilding(Request $request): array
    {
        $validator = new Validator($request->all(), [
            'name' => ['required'],
            'address' => ['required'],
        ], [
            'required' => 'Поле :field пусто',
        ]);

        if ($validator->fails()) {
            (new View())->toJSON(['errors' => $validator->errors()], 422);
        }

        return $request->all();
    }
}