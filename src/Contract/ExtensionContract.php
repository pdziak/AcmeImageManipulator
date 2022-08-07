<?php
declare(strict_types=1);

namespace App\Contract;

interface ExtensionContract {
    public function getUrlValidationRegexp(): string;
    public function process(string $request): array;
}