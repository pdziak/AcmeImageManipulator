<?php
declare(strict_types=1);

namespace App;

use App\Contract\ImageLibrary;
use Imagine\Gd\Imagine;
use Imagine\Image\Point;


class ImagineHandler implements ImageLibrary
{
    private Imagine $lib;

    public function setLibrary(Imagine $imagine)
    {
        $this->lib = $imagine;
    }

    public function crop(int $start, int $end, int $width, int $height)
    {
        $this->lib->crop(new Point($start, $end), $width, $height);
    }

    public function open()
    {
        // TODO: Implement open() method.
    }
}