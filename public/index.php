<?php

require __DIR__ . '/../vendor/autoload.php';

// Load environment variables
try {
    (new \Dotenv\Dotenv(__DIR__ . '/../'))->load();
} catch (\Dotenv\Exception\InvalidPathException $e) {
    die('.env file not found!');
}

// Instantiate the app
$app = new class() extends \DI\Bridge\Slim\App {
    protected function configureContainer(\DI\ContainerBuilder $builder) {
        $builder->addDefinitions(__DIR__ . '/../src/dependencies.php');
    }
};

// Register middleware
require __DIR__ . '/../src/middleware.php';

// Register routes
require __DIR__ . '/../src/routes.php';

// Run app
$app->run();
