<?php
declare(strict_types=1);

namespace App;


use App\Contract\ExtensionContract;

final class Kernel
{
    private string $request;
    private array $requestParts;
    private string $imageFilename;
    private array $extensions;

    public function __construct(string $request, array $extensions)
    {
        $this->request = ltrim($request, "/");
        $this->requestParts = explode("/", $this->request);
        $this->imageFilename = $this->requestParts[0];
        $this->extensions = $extensions;
    }

    public function run()
    {

//        dump($this->extensions);
        foreach ($this->extensions as $extension) {
            $className = "\App\Extension\CropExtension";

            $this->registerExtension(new $className);
        }

        $validator = new RequestValidator($this->request);
        $result = $validator->validate();
        dump($result);
        die;
    }

    private function registerExtension(ExtensionContract $extension)
    {
        $this->extensions[] = $extension;
    }
}