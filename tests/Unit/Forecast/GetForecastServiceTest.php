<?php
declare(strict_types=1);

namespace Tests\Unit\User;

use Mockery;

use League\Fractal\Manager;
use Planet\Domain\Model\Ferengi\Ferengi;
use Planet\Domain\Model\Betasoide\Betasoide;
use Planet\Domain\Model\Vulcano\Vulcano;
use Planet\Domain\Model\Forecast\Forecast;
use Planet\Infrastructure\Service\JsonTransformer;
use League\Fractal\Serializer\DataArraySerializer;
use Planet\Application\Service\Forecast\GetForecastService;
use Planet\Infrastructure\Service\MathService;

class GetForecastServiceTest extends \PHPUnit_Framework_TestCase
{
    /** @test */
    public function testGetForecastService()
    {
        $forecastId = '1';
        $mathService = new MathService();

        $ferengi = new Ferengi($mathService);
        $betasoide = new Betasoide($mathService);
        $vulcano = new Vulcano($mathService);

        $forecast = new Forecast($ferengi, $betasoide, $vulcano);
        $forecast->setDay(566);
        $forecast->setWeather('lluvioso');

        $mockForecast = Mockery::mock('Planet\Domain\Model\Forecast\Forecast');
        $mockForecast->shouldReceive('getDay')->andReturn($forecast->getDay());
        $mockForecast->shouldReceive('getWeather')->andReturn($forecast->getWeather());

        $mockEntityManager = Mockery::mock('Doctrine\ORM\EntityManager');
        $mockEntityManager->shouldReceive('getReference')->with("Planet\Domain\Model\Forecast\Forecast", $forecastId)->andReturn($mockForecast);

        $mockForecastRepository = Mockery::mock('Planet\Infrastructure\Domain\Model\Forecast\DoctrineMysqlForecastRepository');
        $mockForecastRepository->shouldReceive([$mockEntityManager]);
        $mockForecastRepository->shouldReceive('findByDay')->andReturn([$mockForecast]);

        $manager = new Manager();
        $manager->setSerializer(new DataArraySerializer());
        $getForecastService = new GetForecastService($mockForecastRepository, new JsonTransformer($manager));

        $mockGetForecastRequest = Mockery::mock('Planet\Application\Service\Forecast\GetForecastRequest');
        $mockGetForecastRequest->shouldReceive('getDay')->andReturn(566);

        $this->assertSame(566, $getForecastService->execute($mockGetForecastRequest)['dia']);
    }

    public function tearDown() {
        Mockery::close();
    }
}
