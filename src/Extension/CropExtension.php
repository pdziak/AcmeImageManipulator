<?php
declare(strict_types=1);

namespace App\Extension;

use App\Contract\ExtensionContract;

final class CropExtension implements ExtensionContract
{
    const REGEXP_WITHOUT_DELIMITERS = '.*crop-(?<params>([0-9]+,)[0-9]+,[0-9]+,[0-9]+)';

    public function getUrlValidationRegexp(): string
    {
        return self::REGEXP_WITHOUT_DELIMITERS;
    }

    public function process(string $request): void
    {
        $values = $this->parseParams($request);
        list($start, $end, $width, $height) = explode(",", $values);
        dump($end);die;
    }

    private function parseParams(string $request): string {
        preg_match('/'.self::REGEXP_WITHOUT_DELIMITERS.'/', $request, $matches);

        return $matches['params'];
    }
}