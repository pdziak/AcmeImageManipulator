<?php
declare(strict_types=1);

namespace App;

use App\Contract\ValidatorContract;

final class RequestValidator implements ValidatorContract
{
    const FILENAME_REGEXP = '/[a-zA-Z0-9\s]+\.[a-zA-Z]{3,4}/';

    private string $request;

    public function __construct(string $request)
    {
        $this->request = $request;
    }

    public function validate(): bool
    {
        return $this->validateRequestURL();
    }

    private function validateRequestURL(): bool
    {
        return !!preg_match(self::FILENAME_REGEXP, $this->request);
    }


}