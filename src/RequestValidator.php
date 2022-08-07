<?php
declare(strict_types=1);

namespace App;

class RequestValidator
{
    private string $request;

    public function __construct(string $request)
    {
        $this->request = $request;
    }

    public function validate(): bool
    {
        dump($this->request);
    }


}