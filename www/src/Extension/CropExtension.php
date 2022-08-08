<?php
declare(strict_types=1);

namespace App\Extension;

use App\Contract\ExtensionContract;
use Exception;

final class CropExtension extends Exception implements ExtensionContract
{
    const REGEXP_WITHOUT_DELIMITERS = '.*crop-(?<params>([0-9]+,)[0-9]+,[0-9]+,[0-9]+)';

    public function getUrlValidationRegexp(): string
    {
        return self::REGEXP_WITHOUT_DELIMITERS;
    }

    public function getParams(string $request): array
    {
        $values = $this->parseParams($request);
        list($start, $end, $width, $height) = explode(",", $values);

        return [
            'start' => $start,
            'end' => $end,
            'width' => $width,
            'height' => $height
        ];
    }

    private function parseParams(string $request): string
    {
        preg_match('/' . self::REGEXP_WITHOUT_DELIMITERS . '/', $request, $matches);

        return $matches['params'];
    }

    public function getActionName(): string
    {
        return 'crop';
    }
}