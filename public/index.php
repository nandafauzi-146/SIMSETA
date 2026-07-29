<?php

use Illuminate\Foundation\Application;
use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

// Attempt to locate the project base directory (helps when moving `public` into `public_html`).
$possibleBases = [
    __DIR__ . '/../',        // normal layout: public/ -> project root
    __DIR__ . '/../../',     // public_html one level deeper
    __DIR__ . '/../../../',  // other common hosting layouts
    __DIR__ . '/../../laravel-app/',
];

$base = null;
foreach ($possibleBases as $p) {
    if (file_exists($p . 'bootstrap/app.php')) {
        $base = $p;
        break;
    }
}

if (!$base) {
    // fallback to the default expected path
    $base = __DIR__ . '/../';
}

// Determine if the application is in maintenance mode...
if (file_exists($maintenance = $base . 'storage/framework/maintenance.php')) {
    require $maintenance;
}

// Register the Composer autoloader...
require $base . 'vendor/autoload.php';

// Bootstrap Laravel and handle the request...
/** @var Application $app */
$app = require_once $base . 'bootstrap/app.php';

$app->handleRequest(Request::capture());
