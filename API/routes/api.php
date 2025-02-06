<?php
use App\Controllers\UserController;

Flight::route('GET /', [new UserController(), 'hello']);

//Flight::route('GET /state', [new UserController(), 'state']);
Flight::route('GET /users', [new UserController(), 'index']);

// Flight::route('POST /state', [new UserController(), 'store']);
// Flight::route('GET /open', [new UserController(), 'hello']);
// Flight::route('POST /github', [new UserController(), 'store']);



// Flight::route('GET /users/@id', [new UserController(), 'show']);
// Flight::route('POST /users', [new UserController(), 'store']);
// Flight::route('PUT /users/@id', [new UserController(), 'update']);
// Flight::route('DELETE /users/@id', [new UserController(), 'delete']);