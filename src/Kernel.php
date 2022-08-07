<?php
declare(strict_types=1);

namespace App;

use App\Contract\ExtensionContract;
use App\Exception\ValidationException;

final class Kernel
{
    private string $request;
    private array $requestParts;
    private string $imageFilename;
    private array $supportedExtensionNames;
    private array $extensions = [];
    private object $imageLibrary;

    public function __construct(string $request, object $imageLibrary, array $supportedExtensionNames)
    {
        $this->request = ltrim($request, "/");
        $this->requestParts = explode("/", $this->request);
        $this->imageFilename = $this->requestParts[0];
        $this->supportedExtensionNames = $supportedExtensionNames;
        $this->imageLibrary = $imageLibrary;
    }

    /**
     * @throws ValidationException
     */
    public function run()
    {
        foreach ($this->supportedExtensionNames as $extension) {
            $className = "\App\Extension\\$extension";
            $this->registerExtension(new $className);
        }

        $validator = new RequestValidator($this->request);
        if (!$requestValidatorResult = $validator->validate()) {
            throw new ValidationException($requestValidatorResult);
        }

        $extensionValidator = new ExtensionValidator($this->request, $this->extensions);
        if (!$extensionValidatorResult = $extensionValidator->validate()) {
            throw new ValidationException($extensionValidatorResult);
        }

        /**
         * @var $extension ExtensionContract
         */
        foreach ($this->extensions as $extension) {
            $extension->process($this->request);
        }
    }

    private function registerExtension(ExtensionContract $extension)
    {
        $this->extensions[] = $extension;
    }
}