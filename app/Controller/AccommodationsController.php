<?php

namespace Controller;

use Model\Accommodation;
use Model\Room;
use Model\Roomer;
use Src\Request;
use Src\Validator\Validator;
use Src\View;

class AccommodationsController
{    public function create(Request $request): string
    {
        $user = app()->auth->user();
        if (!$user || $user->role_id !== 1) {
            app()->route->redirect('/forbidden');
            exit;
        }

        $roomId = $_GET['room_id'] ?? null;
        $roomerId = $_GET['roomer_id'] ?? null;

        $availableRoomers = Roomer::whereNotIn('id', function($query) {
            $query->select('roomer_id')
                ->from('accommodation')
                ->where('status', 'active');
        })->get();

        $availableRooms = Room::all()->filter(function($room) {
            $occupied = \Model\Accommodation::where('room_id', $room->id)
                ->where('status', 'active')
                ->count();
            return $occupied < $room->capacity;
        });

        return (new View())->render('site.accommodations.create', [
            'rooms' => $availableRooms,
            'roomers' => $availableRoomers,
            'room_id' => $roomId,
            'roomer_id' => $roomerId,
            'old' => []
        ]);
    }

    public function accommodations(Request $request): string
    {

        if ($request->method === 'POST') {
            $user = app()->auth->user();
            if (!$user || $user->role_id !== 1) {
                app()->route->redirect('/forbidden');
                exit;
            }

            $oldInput = $request->all();

            $validator = new Validator($oldInput, [
                'room_id' => ['required'],
                'roomer_id' => ['required'],
                'check_in_date' => ['required'],
            ], [
                'required' => 'Поле :field пусто'
            ]);

            if ($validator->fails()) {
                return (new View())->render('site.accommodations.create', [
                    'rooms' => Room::all(),
                    'roomers' => Roomer::all(),
                    'room_id' => $oldInput['room_id'] ?? null,
                    'roomer_id' => $oldInput['roomer_id'] ?? null,
                    'old' => $oldInput,
                    'errors' => $validator->errors()
                ]);
            }

            if (Accommodation::isRoomerActive($oldInput['roomer_id'])) {
                return (new View())->render('site.accommodations.create', [
                    'rooms' => Room::all(),
                    'roomers' => Roomer::all(),
                    'room_id' => $oldInput['room_id'] ?? null,
                    'roomer_id' => $oldInput['roomer_id'] ?? null,
                    'old' => $oldInput,
                    'errors' => ['roomer_id' => ['Жилец уже заселен в другую комнату']]
                ]);
            }

            $room = Room::find($oldInput['room_id']);
            if ($room) {
                $occupied = Accommodation::query()
                    ->where('room_id', $room->id)
                    ->where('status', 'active')
                    ->count();

                if ($occupied >= $room->capacity) {
                    return (new View())->render('site.accommodations.create', [
                        'rooms' => Room::all(),
                        'roomers' => Roomer::all(),
                        'room_id' => $oldInput['room_id'] ?? null,
                        'roomer_id' => $oldInput['roomer_id'] ?? null,
                        'old' => $oldInput,
                        'errors' => ['room_id' => ['В комнате нет свободных мест']]
                    ]);
                }

                $room->fullness = ($room->fullness ?? 0) + 1;
                $room->save();
            }

            Accommodation::create($oldInput);

            app()->route->redirect('/accommodations');
            exit;
        }
        $accommodations = Accommodation::with(['room', 'roomer'])->get();
        return (new View())->render('site.accommodations.accommodations', [
            'accommodations' => $accommodations
        ]);
    }

    public function checkOut(int $id, Request $request): void
    {
        $user = app()->auth->user();
        if (!$user || $user->role_id !== 1) {
            app()->route->redirect('/forbidden');
            exit;
        }

        $accommodation = Accommodation::find($id);
        if (!$accommodation) {
            app()->route->redirect('/accommodations');
            exit;
        }

        if ($accommodation->status === 'active') {
            $checkOutDate = $_GET['date'] ?? date('Y-m-d');

            $accommodation->check_out_date = $checkOutDate;
            $accommodation->status = 'checked_out';
            $accommodation->save();

            $room = Room::find($accommodation->room_id);
            if ($room && $room->fullness > 0) {
                $room->fullness = $room->fullness - 1;
                $room->save();
            }
        }

        app()->route->redirect('/accommodations');
        exit;
    }
}