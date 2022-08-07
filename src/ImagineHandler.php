<?php
declare(strict_types=1);

namespace App;

use Imagine\Gd\Imagine;

class ImagineHandler {
    private $lib;

    public function (Imagine $imagine) {
        $this->lib = $imagine;
    }

    public function crop(int $start, int $end, int $width, int $height) {
        dump("sdddd'");
    }
}