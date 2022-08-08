<?php
declare(strict_types=1);

namespace App\Extension;

use App\Contract\ExtensionContract;

final class CropExtension extends Extension implements ExtensionContract
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
            'start' => (int)$start,
            'end' => (int)$end,
            'width' => (int)$width,
            'height' => (int)$height
        ];
    }

    private function parseParams(string $request): string
    {
        preg_match('/' . self::REGEXP_WITHOUT_DELIMITERS . '/', $request, $matches);

        return $matches['params'];
    }

    public function process(array $params): object
    {
        return $this->imageLibrary->crop($params['start'], $params['end'], $params['width'], $params['height']);
    }
}