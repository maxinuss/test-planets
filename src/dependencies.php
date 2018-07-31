<?php
declare(strict_types=1);

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Tools\Setup;
use League\Fractal\Manager;
use League\Fractal\Serializer\DataArraySerializer;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Monolog\Processor\UidProcessor;

use Planet\Application\ErrorHandler;
use Planet\Infrastructure\Service\JsonTransformer;
use Planet\Infrastructure\Domain\Model\Forecast\DoctrineMysqlForecastRepository;

use Planet\Domain\Model\Ferengi\Ferengi;
use Planet\Domain\Model\Betasoide\Betasoide;
use Planet\Domain\Model\Vulcano\Vulcano;
use Planet\Infrastructure\Service\MathService;

use Planet\Infrastructure\Console\Command\GetFerengiPredictionCommand;
use Planet\Domain\Model\Forecast\ForecastRepository;
use Planet\Infrastructure\Console\Command\GenerateModelPredictionCommand;

$container = [];
$container['settings'] = [
    'httpVersion' => '1.1',
    'displayErrorDetails' => getenv('ENVIRONMENT') != 'production',
    'environment' => getenv('ENVIRONMENT') ?: 'development',
    'outputBuffering' => 'append',
    'responseChunkSize' => 4096,
    'addContentLengthHeader' => false,
    'determineRouteBeforeAppMiddleware' => true,
    'cachePath' => getenv('CACHE_PATH'),
    'logger' => [
        'name' => 'tweets-app',
        'path' => getenv('LOGS_PATH'). '/app.log',
        'level' => \Monolog\Logger::DEBUG,
    ],
    'doctrine' => [
        'driver' => getenv('DB_DRIVER'),
        'host' => getenv('DB_HOST'),
        'user' => getenv('DB_USERNAME'),
        'password' => getenv('DB_PASSWORD'),
        'dbname' => getenv('DB_NAME'),
    ]
];

$container['errorHandler'] = function ($c) {
    return new ErrorHandler($c->get('logger'), $c->get('settings')['displayErrorDetails']);
};
$container['phpErrorHandler'] = function ($c) {
    return $c->get('errorHandler');
};
$container['notFoundHandler'] = function ($c) {
    return [$c->get('errorHandler'), 'handleNotFound'];
};
$container['notAllowedHandler'] = function ($c) {
    return [$c->get('errorHandler'), 'handleNotAllowed'];
};

$container[JsonTransformer::class] = function ($c) {
    $manager = new Manager();
    $manager->setSerializer(new DataArraySerializer());
    return new JsonTransformer($manager);
};

$container[Ferengi::class] = function ($c) {
    return new Ferengi(new MathService());
};

$container[Betasoide::class] = function ($c) {
    return new Betasoide(new MathService());
};

$container[Vulcano::class] = function ($c) {
    return new Vulcano(new MathService());
};

$container['logger'] = function ($c) {
    $settings = $c->get('settings')['logger'];
    $logger = new Logger($settings['name']);
    $logger->pushProcessor(new UidProcessor());
    $logger->pushHandler(new StreamHandler($settings['path'], $settings['level']));
    return $logger;
};

$container[EntityManagerInterface::class] = function ($c) {
    $settings = $c->get('settings');

    $configuration = Setup::createYAMLMetadataConfiguration(
        [__DIR__ . '/Infrastructure/Persistence/Doctrine/Mapping/Mysql'],
        $settings['environment'] == 'development'
    );
    $configuration->setProxyDir($settings['cachePath'] . '/Proxies');
    return EntityManager::create($settings['doctrine'], $configuration);
};

$container[GetFerengiPredictionCommand::class] = function ($c) {
    return new GetFerengiPredictionCommand(null, $c->get(Ferengi::class), $c->get(Betasoide::class), $c->get(Vulcano::class));
};

$container[GenerateModelPredictionCommand::class] = function ($c) {
    return new GenerateModelPredictionCommand(null, $c->get(Ferengi::class), $c->get(Betasoide::class), $c->get(Vulcano::class), $c->get(ForecastRepository::class));
};

$container[ForecastRepository::class] = function ($c) {
    return new DoctrineMysqlForecastRepository($c->get(EntityManagerInterface::class));
};

return $container;
