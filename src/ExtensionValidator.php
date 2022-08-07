<?php
declare(strict_types=1);

namespace App;

use App\Contract\ExtensionContract;
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

        return !!preg_match($regexp, $this->request);
    }

    private function composeRegexpFromExtensions(): string
    {
        $patterns = [];
        /**
         * @var $extension ExtensionContract
         */
        foreach ($this->extensions as $extension) {
            $patterns[] = $extension->getUrlValidationRegexp();
        }

        return '('.implode('|', $patterns).')';
    }


}