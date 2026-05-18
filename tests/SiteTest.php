<?php
use PHPUnit\Framework\TestCase;
use Model\User;
use Controller\Site;
use Src\Request;
use Src\Application;
use Src\Settings;

class SiteTest extends TestCase
{
    protected function setUp(): void
    {
        // Установка правильного пути для DOCUMENT_ROOT
        $_SERVER['DOCUMENT_ROOT'] = 'C:/xampp/htdocs';
        
        // Загрузка конфигурации приложения
        $configPath = $_SERVER['DOCUMENT_ROOT'] . '/config';
        
        // Инициализация приложения
        $GLOBALS['app'] = new Application(new Settings([
            'app' => include $configPath . '/app.php',
            'db' => include $configPath . '/db.php',
            'path' => include $configPath . '/path.php',
        ]));
        
        // Создание функции app() если она не существует
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
    public function testSignup(string $httpMethod, array $userData, string $message): void
    {
        // Проверка занятого логина
        if ($userData['login'] === 'login is busy') {
            $existingUser = User::get()->first();
            $userData['login'] = $existingUser ? $existingUser->login : 'testuser';
        }

        // Создаем mock для Request
        $request = $this->createMock(Request::class);
        $request->method('all')
            ->willReturn($userData);
        $request->method = $httpMethod;

        // Выполняем регистрацию
        $result = (new Site())->signup($request);

        if (!empty($result)) {
            // Проверяем сообщения об ошибках
            $pattern = '/' . preg_quote($message, '/') . '/';
            $this->expectOutputRegex($pattern);
            return;
        }

        // Проверяем, что пользователь был создан
        $this->assertTrue((bool)User::where('login', $userData['login'])->count());
        
        // Очищаем тестовые данные
        User::where('login', $userData['login'])->delete();
        
        // Проверяем заголовок редиректа
        $this->assertContains($message, xdebug_get_headers());
    }

    public static function additionProvider(): array
    {
        // Генерируем уникальный логин для успешной регистрации
        $uniqueLogin = 'testuser_' . time() . '_' . rand(1000, 9999);

        return [
            // 1. Пустые поля
            [
                'POST',
                ['login' => '', 'password' => '', 'role_id' => null],
                '{"login":["Поле login пусто","Поле login должно быть уникально"],"password":["Поле password пусто"]}'
            ],

            // 2. Пустой логин
            [
                'POST',
                ['login' => '', 'password' => 'password123', 'role_id' => 1],
                '{"login":["Поле login пусто","Поле login должно быть уникально"]}'
            ],

            // 3. Пустой пароль
            [
                'POST',
                ['login' => 'testuser', 'password' => '', 'role_id' => 1],
                '{"password":["Поле password пусто"]}'
            ],

            // 4. Занятый логин
            [
                'POST',
                ['login' => 'login is busy', 'password' => 'anypassword', 'role_id' => 1],
                '{"login":["Поле login должно быть уникально"]}'
            ],

            // 5. Успешная регистрация
            [
                'POST',
                ['login' => $uniqueLogin, 'password' => 'password123', 'role_id' => 2],
                'Location: /login'
            ],
        ];
    }
}