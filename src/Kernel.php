<?php
declare(strict_types=1);

namespace App;


use App\Contract\ExtensionContract;

final class Kernel
{
    private string $request;
    private array $requestParts;
    private string $imageFilename;
    private array $supportedExtensionNames;
    private array $extensions = [];

    public function __construct(string $request, array $supportedExtensionNames)
    {
        $this->request = ltrim($request, "/");
        $this->requestParts = explode("/", $this->request);
        $this->imageFilename = $this->requestParts[0];
        $this->supportedExtensionNames = $supportedExtensionNames;
    }

    public function run()
    {
        foreach ($this->supportedExtensionNames as $extension) {
            $className = "\App\Extension\\$extension";
            $this->registerExtension(new $className);
        }

        $validator = new RequestValidator($this->request);
        $requestValidatorResult = $validator->validate();

        $extensionValidator = new ExtensionValidator($this->request, $this->extensions);
        $extensionValidatorResult = $extensionValidator->validate();


        dump($extensionValidatorResult);die;
        if($requestValidatorResult && $extensionValidatorResult) {

        }

    }

    private function registerExtension(ExtensionContract $extension)
    {
        $this->extensions[] = $extension;
    }
}