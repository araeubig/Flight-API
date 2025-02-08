<?php
require '../vendor/autoload.php';

require '../routes/api.php';

use OpenApi\Attributes as OA;
use Tracy\Debugger;
use flight\debug\tracy\TracyExtensionLoader;

Debugger::enable();
Debugger::$logDirectory = __DIR__ . '/../logs/';
Debugger::$strictMode = true; // alle Fehler anzeigen
// Debugger::$strictMode = E_ALL & ~E_DEPRECATED & ~E_USER_DEPRECATED; // alle Fehler außer veralteten Hinweisen
// if (Debugger::$showBar) {
//     $app->set('flight.content_length', false); // Wenn die Debugger-Leiste sichtbar ist, kann die Inhaltslänge nicht von Flight festgelegt werden

//     // Dies ist spezifisch für die Tracy-Erweiterung für Flight, wenn Sie diese eingeschlossen haben
//     // Andernfalls kommentieren Sie dies aus.
//     new TracyExtensionLoader($app);
// }
Flight::set('flight.log_errors', true);

Flight::start();
