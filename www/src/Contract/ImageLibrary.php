<?php
declare(strict_types=1);

namespace App\Contract;

interface ImageLibrary
{
    public function open(string $file);

    public function crop(int $start, int $end, int $width, int $height);
}