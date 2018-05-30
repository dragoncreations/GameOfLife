<?php

declare(strict_types = 1);

require 'vendor/autoload.php';

use Slim\App;
use Noodlehaus\Config;
use GameOfLife\Game;
use GameOfLife\Grid;
use GameOfLife\File;

$app = new App();

$config = Config::load('config.yml');

$dir = __DIR__ . DIRECTORY_SEPARATOR . 'tmp';

if (!is_dir($dir)) {
    if (!mkdir($dir, 0777, true)) {
        die('Failed to create folder...');
    }
}

$file = new File($dir . DIRECTORY_SEPARATOR . 'game.json');

$app->get('/tick', function() use (&$file) {
    $game = new Game($file);
    $game->tick();
    echo $game->renderGrid();
});

$app->post('/seed', function($request) use (&$config, &$file) {
    $game = new Game($file, new Grid($config->get('width'), $config->get('height')));
    $game->seed($request->getParsedBody()['template']);
    echo $game->renderGrid();
});

$app->run();
