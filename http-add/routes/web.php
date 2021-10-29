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
use Laravel\Lumen\Http\ResponseFactory;

$router->get('/', function (ResponseFactory $responseFactory) use ($router) {
    if (! isset($_GET['name'])) {
        return $responseFactory->make('', 404);
    }
    $event = Event::query()->create([
        'name' => $_GET['name'],
    ]);

    return "Created event with id {$event->getKey()}";
});
