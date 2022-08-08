<?php
declare(strict_types=1);

use App\ImagineHandler;

ini_set("display_errors", (string)1);
error_reporting(E_ALL);

require __DIR__ . '/vendor/autoload.php';

if (!isset($_GET['s'])) {
    http_response_code(400);
    exit(0);
}

/**
 * uppercase class name, eg. CropExtension, GrayscaleException
 */
$extensions = [
    'CropExtension'
];

$app = new App\Kernel($_GET['s'], new ImagineHandler(), $extensions);
$app->run();

