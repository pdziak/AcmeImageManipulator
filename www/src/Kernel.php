<?php
declare(strict_types=1);

namespace App;

use App\Contract\ExtensionContract;
use App\Contract\ImageLibrary;
use App\Exception\ValidationException;
use Imagine\Gd\Imagine;

final class Kernel
{
    const UPLOADS_PATH = 'uploads';
    const TEMP_PATH = 'tmp';
    const ACTION_SHOW = 'show';
    const ACTION_PROCESS = 'process';

    private string $request;
    private array $requestParts;
    private string $filename;
    private array $supportedExtensionNames;
    private array $extensions = [];
    private ImageLibrary $imageLibrary;
    private string $route = self::ACTION_PROCESS;

    public function __construct(string $request, ImageLibrary $imageLibrary, array $supportedExtensionNames)
    {
        $this->request = preg_replace('@^/s/(.+)@', '$1', $request, -1, $count);
        if ($count) {
            $this->route = self::ACTION_SHOW;
        }

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
        if ($this->route === self::ACTION_SHOW) {
            return $this->show();
        }

        $this->process();
    }

    private function show()
    {
        header("Content-type: image");
        $file = file_get_contents($this->getRootDir() . '/' . self::TEMP_PATH . '/' . $this->filename);
        echo $file;
        exit(0);
    }

    private function getRootDir(): string
    {
        return dirname(__FILE__) . '/..';
    }

    private function process()
    {
        foreach ($this->supportedExtensionNames as $extension) {
            $className = "\App\Extension\\$extension";
            $this->registerExtension(new $className($this->imageLibrary));
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
            $img = $extension->process($file);
            $file = $img;
        }

        $file->save($rootDir . '/' . self::TEMP_PATH . '/' . $this->filename);
    }

    private function registerExtension(ExtensionContract $extension)
    {
        $this->extensions[] = $extension;
    }
}