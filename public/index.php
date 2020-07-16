<?php

use App\Bootstrap\AppManager;
use DI\ContainerBuilder;
use Dotenv\Dotenv;

require dirname(__DIR__) . '/vendor/autoload.php';

// Initialize environment variable handler
Dotenv::createUnsafeImmutable(dirname(__DIR__))->safeLoad();

// Initialize the container
$container = (new ContainerBuilder)->addDefinitions(
    ...glob(dirname(__DIR__) . '/config/*.php')
);

// Compile the container
if (filter_var(getenv('APP_DEBUG'), FILTER_VALIDATE_BOOLEAN) !== true) {
    $container->enableCompilation(__DIR__ . '/cache');
}

// Initialize the application
$app = $container->build()->call(AppManager::class);

// Engage!
$app->run();
