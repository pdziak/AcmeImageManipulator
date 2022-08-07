<?php
declare(strict_types=1);

ini_set("display_errors", (string)1);

require __DIR__ . '/vendor/autoload.php';

if(!isset($_GET['s'])) {
    http_response_code(400);
    exit(0);
}

$app = new App\Kernel($_GET['s']);
$app->run();

