<?php
declare(strict_types=1);

namespace App\Contract;

interface ExtensionContract {
    public function getUrlValidationRegexp(): string;
    public function getParams(string $request): array;
    public function process($file, array $params);
}