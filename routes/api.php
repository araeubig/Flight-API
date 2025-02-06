<?php

// use App\Controllers\UserController;

// Flight::route('GET /users', [new UserController(), 'index']);
// Flight::route('GET /users/@id', [new UserController(), 'show']);
// Flight::route('POST /users', [new UserController(), 'store']);
// Flight::route('PUT /users/@id', [new UserController(), 'update']);
// Flight::route('DELETE /users/@id', [new UserController(), 'delete']);

use App\Controllers\StateController;

Flight::route('GET /', [new StateController(), 'hello']);
Flight::route('GET /state', [new StateController(), 'last']);
Flight::route('POST /state', [new StateController(), 'store']);

// Flight::route('GET /users', [new StateController(), 'index']);
// Flight::route('GET /users/@id', [new StateController(), 'show']);
// Flight::route('POST /users', [new StateController(), 'store']);
// Flight::route('PUT /users/@id', [new StateController(), 'update']);
// Flight::route('DELETE /users/@id', [new StateController(), 'delete']);
