<?php


class CropExtension implements ExtensionContract
{
    public function getUrlValidationRegexp(): string
    {
        return 'crop-[0-9]+,[0-9]+';
    }
}