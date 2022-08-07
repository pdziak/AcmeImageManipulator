<?php
declare(strict_types=1);

ini_set("display_errors", (string)1);

require __DIR__ . '/vendor/autoload.php';

$imageManipulator = new App\Kernel($_GET['s']);