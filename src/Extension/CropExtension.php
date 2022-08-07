<?php
declare(strict_types=1);

namespace App\Extension;

use App\Contract\ExtensionContract;

final class CropExtension implements ExtensionContract
{
    public function getUrlValidationRegexp(): string
    {
        return 'crop-[0-9]+,[0-9]+';
    }
}