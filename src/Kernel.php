<?php
declare(strict_types=1);

namespace App;

use App\Contract\ExtensionContract;
use App\Exception\ValidationException;
use Imagine\Gd\Image;
use Imagine\Gd\Imagine;

final class Kernel
{
    const UPLOADS_PATH = 'uploads';

    private string $request;
    private array $requestParts;
    private string $filename;
    private array $supportedExtensionNames;
    private array $extensions = [];
    private object $imageLibrary;

    public function __construct(string $request, Imagine $imageLibrary, array $supportedExtensionNames)
    {
        $this->request = ltrim($request, "/");
        $this->requestParts = explode("/", $this->request);
        $this->filename = $this->requestParts[0];
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
        if (!$validator->validate()) {
            throw new ValidationException('Wrong url');
        }

        $extensionValidator = new ExtensionValidator($this->request, $this->extensions);
        if (!$extensionValidator->validate()) {
            throw new ValidationException('Wrong image modifier URL');
        }

        $rootDir = $this->getRootDir();
        $file = $this->imageLibrary->open($rootDir . '/' . self::UPLOADS_PATH . '/' . $this->filename);

        /**
         * @var $extension ExtensionContract
         */
        foreach ($this->extensions as $extension) {
            $img = $extension->process($file, $extension->getParams($this->request));
            $file = $img;
        }
    }

    private function registerExtension(ExtensionContract $extension)
    {
        $this->extensions[] = $extension;
    }

    private function getRootDir(): string
    {
        return dirname(__FILE__) . '/..';
    }
}