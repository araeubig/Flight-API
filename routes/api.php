<?php

//use App\Controllers\UserController;
use App\Controllers\ValueController;
use App\Controllers\GithubController;

// Flight::route('GET /users', [new UserController(), 'index']);
// Flight::route('GET /users/@id', [new UserController(), 'show']);
// Flight::route('POST /users', [new UserController(), 'store']);
// Flight::route('PUT /users/@id', [new UserController(), 'update']);
// Flight::route('DELETE /users/@id', [new UserController(), 'delete']);

// Flight::group('', function() {

    Flight::route('GET /', [new ValueController(), 'documentation']);
    Flight::route('GET /values', [new ValueController(), 'last']);
    Flight::route('GET /openstate', [new ValueController(), 'open']);
    Flight::route('GET /github', [new GithubController(), 'github']);
    Flight::route('POST /values', [new ValueController(), 'store']);
    Flight::route('POST /github', [new GithubController(), 'store']);

// }, [ new Authentication() ]);