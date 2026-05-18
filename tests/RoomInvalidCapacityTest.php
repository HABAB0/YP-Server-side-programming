<?php
use PHPUnit\Framework\TestCase;
use Model\Room;
use Controller\RoomsController;
use Src\Request;
use Src\Application;
use Src\Settings;

class RoomInvalidCapacityTest extends TestCase
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
     * @dataProvider invalidCapacityProvider
     */
    public function testCreateRoomWithInvalidCapacity(array $roomData, string $expectedError, string $expectedRedirect): void
    {
        // Сохранляем исходное количество комнат
        $initialRoomCount = Room::count();
        
        // Создаем mock для Request
        $request = $this->createMock(Request::class);
        $request->method('all')
            ->willReturn($roomData);
        $request->method = 'POST';

        // Выполняем создание комнаты
        $result = (new RoomsController())->roomCreate($request);

        if (!empty($result)) {
            // Проверяем сообщение об ошибке валидации
            $pattern = '/' . preg_quote($expectedError, '/') . '/';
            $this->expectOutputRegex($pattern);
            
            // Проверяем заголовок редиректа
            $this->assertContains($expectedRedirect, xdebug_get_headers());
            
            // Проверяем, что количество комнат не изменилось
            $this->assertEquals($initialRoomCount, Room::count());
        }
    }

    public static function invalidCapacityProvider(): array
    {
        return [
            [
                [
                    'building_id' => 1,
                    'number' => '1401',
                    'capacity' => -7,
                    'type' => 'Мужская'
                ],
                'Поле capacity должно быть числом',
                'Location: /rooms/create'
            ],
        ];
    }
}