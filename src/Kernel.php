<?php
declare(strict_types=1);

namespace App;

final class Kernel {
    private string $request;
    private array $requestParts;
    private string $imageFilename;

    public function __construct(string $request) {
        $this->request = ltrim($request, "/");
        $this->requestParts = explode("/", $this->request);
        $this->imageFilename = $this->requestParts[0];
    }

    public function run() {
        $validator = new RequestValidator($this->request);
        $validator->validate();
    }
}