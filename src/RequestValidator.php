<?php
declare(strict_types=1);

namespace App;

final class RequestValidator
{

    const VALID_REQUEST_URL_REGEXP = '/[a-zA-Z0-9\s]+\.[a-zA-Z]{3,4} ([a-z\-(a-z0-9,)]/';

    private string $request;

    public function __construct(string $request)
    {
        $this->request = $request;
    }

    public function validate(): bool
    {
        dump($this->request);
        return $this->validateRequestURL();
    }

    private function validateRequestURL()
    {
        return !!preg_match(self::VALID_REQUEST_URL_REGEXP, $this->request);
    }


}