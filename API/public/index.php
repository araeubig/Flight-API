<?php

// Wenn Sie Composer verwenden, erfordern Sie den Autoloader.
require '../vendor/autoload.php';
// Wenn Sie Composer nicht verwenden, laden Sie das Framework direkt
// require 'flight/Flight.php';

require '../routes/api.php';

// // Definieren Sie dann eine Route und weisen Sie eine Funktion zur Behandlung der Anfrage zu.
// Flight::route('/', function () {
//   echo 'Hallo Welt!';
// });

// Starten Sie das Framework schließlich.
Flight::start();