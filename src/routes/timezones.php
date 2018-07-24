<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

$app = new \Slim\App;

// get all timezones

$app->get('/api/timezones', function (Request $request, Response $response, array $args) {
    echo 'timezones';
});