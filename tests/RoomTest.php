<?php
use PHPUnit\Framework\TestCase;
use Model\Room;
use Model\Building;
use Controller\RoomsController;
use Src\Request;
use Src\Application;
use Src\Settings;

class RoomTest extends TestCase
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
     * @dataProvider roomProvider
     */
    public function testCreateRoom(array $roomData, string $expectedRedirect): void
    {
        // Проверка, что комната с таким номером еще не существует
        if ($roomData['number'] === 'existing_room') {
            $existingRoom = Room::get()->first();
            $roomData['number'] = $existingRoom ? $existingRoom->number : '4023';
        }

        // Создаем mock для Request
        $request = $this->createMock(Request::class);
        $request->method('all')
            ->willReturn($roomData);
        $request->method = 'POST';

        // Выполняем создание комнаты
        $result = (new RoomsController())->roomCreate($request);

        if (!empty($result)) {
            // Проверяем заголовок редиректа
            $this->assertContains($expectedRedirect, xdebug_get_headers());
            
            // Проверяем, что комната была создана
            $this->assertTrue((bool)Room::where('number', $roomData['number'])->count());
            
            // Очищаем тестовые данные
            Room::where('number', $roomData['number'])->delete();
        }
    }

    public static function roomProvider(): array
    {
        return [
            [
                [
                    'building_id' => 1,
                    'number' => '4023',
                    'capacity' => 7,
                    'type' => 'Мужская'
                ],
                'Location: /rooms'
            ]
        ];
    }
}