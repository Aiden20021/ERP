<?php

namespace Mpdf;

use DirectoryIterator;

class Cache
{
    private $basePath;
    private $cleanupInterval;

    public function __construct($basePath, $cleanupInterval = 3600)
    {
        if (!is_int($cleanupInterval) && $cleanupInterval !== false) {
            throw new \Mpdf\MpdfException('Cache cleanup interval moet een integer of false zijn.');
        }

        $this->basePath = $basePath;
        $this->cleanupInterval = $cleanupInterval;

        // Controleer of de basis-cachemap bestaat
        if (!$this->createBasePath($this->basePath)) {
            throw new \Exception("De basis-cachemap kan niet worden aangemaakt of beschreven: {$this->basePath}");
        }
    }

    protected function createBasePath($basePath)
    {
        if (!file_exists($basePath)) {
            if (!$this->createBasePath(dirname($basePath))) {
                return false;
            }
            if (!$this->createDirectory($basePath)) {
                return false;
            }
        }

        if (!is_writable($basePath) || !is_dir($basePath)) {
            return false;
        }

        return true;
    }

    protected function createDirectory($basePath)
    {
        if (!mkdir($basePath, 0777, true) && !is_dir($basePath)) {
            return false;
        }

        if (!chmod($basePath, 0777)) {
            return false;
        }

        return true;
    }

    public function tempFilename($filename)
    {
        return $this->getFilePath($filename);
    }

    public function has($filename)
    {
        return file_exists($this->getFilePath($filename));
    }

    public function load($filename)
    {
        return file_get_contents($this->getFilePath($filename));
    }

    public function write($filename, $data)
    {
        // Zorg dat de basePath bestaat en beschrijfbaar is
        if (!$this->createBasePath($this->basePath)) {
            throw new \Exception("De basis-cachemap kan niet worden aangemaakt of beschreven.");
        }

        // Maak een tijdelijk bestand in een toegankelijke map
        $tempFile = tempnam($this->basePath, 'cache_tmp_');
        if ($tempFile === false) {
            throw new \Exception("Kon geen tijdelijk bestand aanmaken in {$this->basePath}.");
        }

        file_put_contents($tempFile, $data);
        chmod($tempFile, 0664);

        $path = $this->getFilePath($filename);
        if (!rename($tempFile, $path)) {
            throw new \Exception("Kon het tijdelijke bestand niet verplaatsen naar de cachemap: {$path}");
        }

        return $path;
    }

    public function remove($filename)
    {
        return unlink($this->getFilePath($filename));
    }

    public function clearOld()
    {
        $iterator = new DirectoryIterator($this->basePath);

        /** @var \DirectoryIterator $item */
        foreach ($iterator as $item) {
            if (!$item->isDot()
                && $item->isFile()
                && !$this->isDotFile($item)
                && $this->isOld($item)) {
                unlink($item->getPathname());
            }
        }
    }

    private function getFilePath($filename)
    {
        return $this->basePath . DIRECTORY_SEPARATOR . $filename;
    }

    private function isOld(DirectoryIterator $item)
    {
        return $this->cleanupInterval
            ? $item->getMTime() + $this->cleanupInterval < time()
            : false;
    }

    public function isDotFile(DirectoryIterator $item)
    {
        return substr($item->getFilename(), 0, 1) === '.';
    }
}
