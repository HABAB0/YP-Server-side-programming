<?php

namespace Controller;

use Model\Roomer;
use Src\Request;
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
}