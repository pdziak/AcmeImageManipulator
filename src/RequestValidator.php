<?php
declare(strict_types=1);

namespace App;

class RequestValidator
{

    const VALID_REQUEST_URL_REGEXP = '/[^A-Za-z0-9 _ .-]/';

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