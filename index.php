<?php
declare(strict_types=1);

ini_set("display_errors", (string)1);

require __DIR__ . '/vendor/autoload.php';

if(!isset($_GET['s'])) {
    http_response_code(400);
    exit(0);
}

/**
 * uppercase class name, eg. CropExtension, GrayscaleException
 */
$extensions = [
    'CropExtension'
];

$app = new App\Kernel($_GET['s'], $extensions);
$app->run();

