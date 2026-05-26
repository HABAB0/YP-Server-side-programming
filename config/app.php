<?php
return [
    //Класс аутентификации
    'auth' => \Src\Auth\Auth::class,
    //Клас пользователя
    'identity' => \Model\User::class,
    //Классы для middleware
    'routeMiddleware' => [
        'auth' => \Middlewares\AuthMiddleware::class,
        'admin' => \Middlewares\AdminMiddleware::class,
        'bearer' => \Middlewares\BearerAuthMiddleware::class,
    ],
    'validators' => [
        'required' => \habab0\Validators\Validators\RequireValidator::class,
        'unique' => \habab0\Validators\Validators\UniqueValidator::class,
        'numeric' => \habab0\Validators\Validators\NumberValidator::class
    ],
    'routeAppMiddleware' => [
        'csrf' => \Middlewares\CSRFMiddleware::class,
        'specialChars' => \Middlewares\SpecialCharsMiddleware::class,
        'trim' => \Middlewares\TrimMiddleware::class,
        'json' => \Middlewares\JSONMiddleware::class,
    ],
];