<?php
declare(strict_types=1);

namespace App;

use App\Contract\ValidatorContract;

final class ExtensionValidator implements ValidatorContract
{
    private string $request;
    private array $extensions;

    public function __construct(string $request, array $extensions)
    {
        $this->request = $request;
        $this->extensions = $extensions;
    }

    public function validate(): bool
    {
        $regexp = $this->composeRegexpFromExtensions();
    }

    private function composeRegexpFromExtensions()
    {
        dd($this->extensions);
    }


}