<?php
use PHPUnit\Framework\TestCase;
use Model\Room;
use Controller\RoomsController;
use Src\Request;
use Src\Application;
use Src\Settings;

class DuplicateRoomTest extends TestCase
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
     * @dataProvider duplicateRoomProvider
     */
    public function testCreateDuplicateRoom(array $roomData, string $expectedError, string $expectedRedirect): void
    {
        // Проверяем, что тестовая комната уже существует
        $existingRoom = Room::where('room_number', $roomData['room_number'])->first();
        if (!$existingRoom) {
            // Создаем тестовую комнату, если ее нет в базе данных
            Room::create([
                'building_id' => $roomData['building_id'],
                'room_number' => $roomData['room_number'],
                'capacity' => $roomData['capacity'],
                'type' => $roomData['type']
            ]);
        }

        // Создаем mock для Request
        $request = $this->createMock(Request::class);
        $request->method('all')
            ->willReturn($roomData);
        $request->method = 'POST';

        // Выполняем создание комнаты
        $result = (new RoomsController())->roomCreate($request);

        if (!empty($result)) {
            // Проверяем сообщение об ошибке
            $pattern = '/' . preg_quote($expectedError, '/') . '/';
            $this->expectOutputRegex($pattern);
            
            // Проверяем заголовок редиректа
            $this->assertContains($expectedRedirect, xdebug_get_headers());
        }
    }

    public static function duplicateRoomProvider(): array
    {
        return [
            [
                [
                    'building_id' => 1,
                    'room_number' => '101',
                    'capacity' => 7,
                    'type' => 'Мужская'
                ],
                'Поле room_number должно быть уникальным',
                'Location: /rooms/create'
            ]
        ];
    }
}