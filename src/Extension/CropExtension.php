<?php
declare(strict_types=1);

namespace App\Extension;

use App\Contract\ExtensionContract;
use Exception;
use Imagine\Gd\Image;
use Imagine\Image\Box;
use Imagine\Image\Point;

final class CropExtension implements ExtensionContract
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

    /**
     * @param \Imagine\Gd\Image $file
     * @throws Exception
     */
    public function process($file, array $params): Image
    {
        if ($file instanceof Image) {
            return $file->crop(new Point($params['start'], $params['end']), new Box($params['width'], $params['height']));
        }

        throw new Exception('Unsupported image library');
    }

    public function getActionName(): string
    {
        return 'crop';
    }
}