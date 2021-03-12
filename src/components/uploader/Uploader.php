<?php

namespace app\components\uploader;

use app\components\FilenameGenerator;
use app\extensions\file\File;
use app\extensions\image\Image;
use RuntimeException;
use yii\web\UploadedFile;

class Uploader
{
    public string $rootPath = 'upload';
    public string $emptyImage = '';
    /**
     * @var array
     * @psalm-var array<array-key, array{0: string, 1: string[]}>
     */
    public array $allowedThumbnailResolutions = [];
    public int $directoryRights = 755;

    private File $file;
    private Image $image;

    public function __construct(File $file, Image $image)
    {
        $this->file = $file;
        $this->image = $image;
    }

    public function upload(UploadedFile $file, string $path): ?File
    {
        if (!is_dir($path)) {
            $this->file->set($path)->createDir($this->directoryRights);
        }

        $extension = strtolower($file->getExtension());
        $fileName = FilenameGenerator::generate($path, $extension);
        $baseName = $fileName . '.' . $extension;

        $main = $path . '/' . $baseName;

        if ($file->saveAs($main)) {
            return $this->file->set($main);
        }

        return null;
    }

    public function uploadByUrl(string $url, string $path, string $extension): ?File
    {
        $content = file_get_contents($url);

        if ($content) {
            $fileName = FilenameGenerator::generate($path, $extension);
            $baseName = $fileName . '.' . $extension;

            $orig = $path . '/' . $baseName;

            $f = fopen($orig, 'wb');
            fwrite($f, $content);
            fclose($f);

            return $this->file->set($orig);
        }
        return null;
    }

    public function delete(string $baseName, string $path): bool
    {
        if (!$baseName) {
            return false;
        }

        if (!preg_match('|^' . $this->rootPath . '|s', $path)) {
            return false;
        }

        $dir = $this->file->set($path);

        if (!$dir->getContents()) {
            return false;
        }

        $file = $this->file->set($path . '/' . $baseName);
        $fileName = $file->getFilename();
        $extension = ($ext = $file->getExtension()) ? '\.' . $ext : '';

        if (!$fileName) {
            return false;
        }

        /** @var string $currentFile */
        foreach ($dir->getContents() as $currentFile) {
            if (preg_match('|^' . $fileName . '.*' . $extension . '$|s', basename($currentFile))) {
                @unlink($currentFile);
            }
        }

        return true;
    }

    public function getUrl(string $path, string $baseName): string
    {
        if (!$baseName) {
            return $this->emptyImage;
        }

        if (!file_exists($path . '/' . $baseName)) {
            $this->createThumb($path, $baseName);
        }

        return $path . '/' . $baseName;
    }

    public function getThumbUrl(string $path, string $baseName, int $width = 0, int $height = 0): string
    {
        if (!$baseName) {
            return $this->emptyImage;
        }

        if (!$this->isAllowedResolution($path, $width, $height)) {
            return '';
        }

        $baseName = $this->createThumbFileName($baseName, $width, $height);

        return $baseName ? $path . '/' . $baseName : '';
    }

    public function checkThumbExists(string $fileName): bool
    {
        if (file_exists($fileName)) {
            return true;
        }

        if (!$requested = $this->parseFileName($fileName)) {
            return false;
        }

        if (!$this->isAllowedResolution($requested->path, $requested->width, $requested->height)) {
            return false;
        }

        if ($this->createThumb(
            $requested->path,
            $requested->baseName,
            $requested->width,
            $requested->height
        ) === null) {
            return false;
        }

        return true;
    }

    public function createThumb(string $path, string $baseName, int $width = 0, int $height = 0): ?Image
    {
        $fileName = $path . '/' . $baseName;

        if (!file_exists($fileName)) {
            return null;
        }

        /**
         * @var Image $orig
         * @var Image $thumb
         */

        if ($orig = $this->image->load($fileName)) {
            if ($width && $height) {
                $thumb = $orig->adaptiveThumb($width, $height);
            } else {
                $thumb = $orig->thumb($width ?: false, $height ?: false);
            }

            $targetName = $path . '/' . $this->createThumbFileName($baseName, $width, $height);

            if (!$thumb->save($targetName, false, 100)) {
                throw new RuntimeException('Unable to save ' . $targetName);
            }

            if (!$thumb->save($targetName . '.webp', Image::IMG_WEBP, 100)) {
                throw new RuntimeException('Unable to save ' . $targetName . 'webp');
            }
            return $thumb;
        }

        return null;
    }

    public function createThumbFileName(string $baseName, int $width, int $height): string
    {
        if ($width || $height) {
            if (preg_match('|^(?P<name>[\w-]+)\.(?P<extension>\w+)$|', $baseName, $matches)) {
                $fileName = $matches['name'];
                $extension = '.' . $matches['extension'];
            } else {
                $fileName = $baseName;
                $extension = '';
            }

            return $fileName . '_' . $width . 'x' . $height . $extension;
        }
        return $baseName;
    }

    private function parseFilename(string $fileName): ?Parsed
    {
        $result = null;

        $pattern = '|^(?P<path>' . $this->rootPath .
            '/[/\w]+)/(?P<name>\w+)_(?P<width>\d+)x?(?P<height>\d+)?\.(?P<ext>\w+)(\.webp)?$|';

        if (preg_match($pattern, $fileName, $matches)) {
            $result = new Parsed();
            $result->path = $matches['path'];
            $result->fileName = $matches['name'];
            $result->width = (int)($matches['width'] ?? 0);
            $result->height = (int)($matches['height'] ?? 0);
            $result->extension = $matches['ext'];
            $result->baseName = $matches['name'] . '.' . $matches['ext'];
        }

        return $result;
    }

    private function isAllowedResolution(string $path, int $width, int $height): bool
    {
        $resolution = $width . 'x' . $height;

        foreach ($this->allowedThumbnailResolutions as $rule) {
            if (mb_strpos($path, $rule[0], 0, 'UTF-8') === 0) {
                if (in_array($resolution, $rule[1], true)) {
                    return true;
                }
            }
        }
        return false;
    }
}
