<?php
declare(strict_types=1);

namespace App;

use App\Contract\ImageLibrary;
use Imagine\Gd\Image;
use Imagine\Gd\Imagine;
use Imagine\Image\Box;
use Imagine\Image\Point;


class ImagineHandler implements ImageLibrary
{
    private Imagine $lib;
    private Image $file;

    public function __construct()
    {
        $this->lib = new Imagine();
    }

    public function crop(int $start, int $end, int $width, int $height)
    {
        $this->file->crop(new Point($start, $end), new Box($width, $height));
    }

    public function open(string $file)
    {
        $this->file = $this->lib->open($file);
    }

    public function getFile()
    {
        return $this->file;
    }
}