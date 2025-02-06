<?php
require '../vendor/autoload.php';
//require '../routes/api.php';

Flight::route('/', function(){
    echo 'Hello, world!';
});

Flight::start();