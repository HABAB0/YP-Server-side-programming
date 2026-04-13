<?php
use PHPUnit\Framework\TestCase;
use Model\User;
use Controller\Site;
use Src\Request;

class SiteTest extends TestCase
{

    protected function setUp(): void
    {
        //Установка переменной среды
        $_SERVER['DOCUMENT_ROOT'] = '/var/www';

       $GLOBALS['app'] = new Src\Application(new Src\Settings([
           'app' => include $_SERVER['DOCUMENT_ROOT'] . './config/app.php',
           'db' => include $_SERVER['DOCUMENT_ROOT'] . './config/db.php',
           'path' => include $_SERVER['DOCUMENT_ROOT'] . './config/path.php',
       ]));
       if (!function_exists('app')) {
           function app()
           {
               return $GLOBALS['app'];
           }
       }
    }

    /**
     * @dataProvider additionProvider
     */

//Метод, возвращающий набор тестовых данных
    public function additionProvider(): array
    {
        $uniqueLogin = 'testuser_' . time() . '_' . rand(1000, 9999);

        return [
            [
                'POST',
                ['login' => '', 'password' => ''],
                '{"login":["Поле login пусто"],"password":["Поле password пусто"]}'
            ],


            [
                'POST',
                ['login' => '', 'password' => 'password123'],
                '{"login":["Поле login пусто"]}'
            ],

            [
                'POST',
                ['login' => 'testuser', 'password' => ''],
                '{"password":["Поле password пусто"]}'
            ],

            [
                'POST',
                ['login' => 'admin', 'password' => 'anypassword'],
                '{"login":["Поле login должно быть уникально"]}'
            ],

            [
                'POST',
                ['login' => $uniqueLogin, 'password' => 'password123', 'role_id' => 2],
                'Location: /login'
            ],
        ];
    }

    public function testSignup(string $httpMethod, array $userData, string $message): void
    {
        //Выбираем занятый логин из базы данных
        if ($userData['login'] === 'login is busy') {
            $userData['login'] = User::get()->first()->login;
        }

        // Создаем заглушку для класса Request.
        $request = $this->createMock(\Src\Request::class);
        // Переопределяем метод all() и свойство method
        $request->expects($this->any())
            ->method('all')
            ->willReturn($userData);
        $request->method = $httpMethod;

        //Сохраняем результат работы метода в переменную
        $result = (new \Controller\Site())->signup($request);

        if (!empty($result)) {
            //Проверяем варианты с ошибками валидации
            $message = '/' . preg_quote($message, '/') . '/';
            $this->expectOutputRegex($message);
            return;
        }

        //Проверяем добавился ли пользователь в базу данных
        $this->assertTrue((bool)User::where('login', $userData['login'])->count());
        //Удаляем созданного пользователя из базы данных
        User::where('login', $userData['login'])->delete();

        //Проверяем редирект при успешной регистрации
        $this->assertContains($message, xdebug_get_headers());
    }
}