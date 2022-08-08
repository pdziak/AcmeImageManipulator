<?php
declare(strict_types=1);



namespace App\Extension;


use App\Contract\ImageLibrary;

abstract class Extension
{
    protected ImageLibrary $imageLibrary;

    public function __construct(ImageLibrary $imageLibrary) {
        $this->imageLibrary = $imageLibrary;
    }
}