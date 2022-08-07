<?php
declare(strict_types=1);

interface ExtensionContract {
    public function getUrlValidationRegexp(): string;
}