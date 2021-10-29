<?php

/** @var \Laravel\Lumen\Routing\Router $router */

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

use App\Models\Event;

$router->get('/', function () use ($router) {
    // phpinfo();
    $events = Event::query()->latest()->limit(15);
    echo '<h1>Latest 15 events:</h1>';
    $events->each(function (Event $event) {
        echo "{$event->getName()}<br/>";
    });
});
