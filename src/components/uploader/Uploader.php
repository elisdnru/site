<?php

namespace app\components\uploader;

use app\components\FileHelper;
use app\extensions\file\File;
use app\extensions\image\ImageHandler;
use CUploadedFile;
use StdClass;
use Yii;

class Uploader
{
    public $rootPath = 'upload';
    public $emptyImage = '';
    public $allowedThumbnailResolutions = [];
    public $directoryRights = 755;

    public function upload(CUploadedFile $file, string $path): ?File
    {
        if (!is_dir($path)) {
            Yii::$app->file->set($path)->createDir($this->directoryRights);
        }

        $extension = strtolower($file->extensionName);
        $fileName = FileHelper::getRandomFileName($path, $extension);
        $baseName = $fileName . '.' . $extension;

        $main = $path . '/' . $baseName;

        if ($file->saveAs($main)) {
            return Yii::$app->file->set($main);
        }

        return null;
    }

    public function uploadByUrl(string $url, string $path, string $extension): ?File
    {
        $content = file_get_contents($url);

        if ($content) {
            $fileName = FileHelper::getRandomFileName($path, $extension);
            $baseName = $fileName . '.' . $extension;

            $orig = $path . '/' . $baseName;

            $f = fopen($orig, 'w');
            fwrite($f, $content);
            fclose($f);

            return Yii::$app->file->set($orig);
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

        $dir = Yii::$app->file->set($path);

        if (!$dir->getContents()) {
            return false;
        }

        $file = Yii::$app->file->set($path . '/' . $baseName);
        $fileName = $file->getFilename();
        $extension = $file->getExtension() ? '\.' . $file->getExtension() : '';

        if (!$fileName) {
            return false;
        }

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

        if (!$this->createThumb($requested->path, $requested->baseName, $requested->width, $requested->height)) {
            return false;
        }

        return true;
    }

    public function createThumb(string $path, string $baseName, int $width = 0, int $height = 0): bool
    {
        $fileName = $path . '/' . $baseName;

        if (!file_exists($fileName)) {
            return false;
        }

        /** @var $orig ImageHandler */
        /** @var $thumb ImageHandler */

        if ($orig = Yii::$app->image->load($fileName)) {
            if ($width && $height) {
                $thumb = $orig->adaptiveThumb($width, $height);
            } else {
                $thumb = $orig->thumb($width ?: false, $height ?: false);
            }

            $targetName = $path . '/' . $this->createThumbFileName($baseName, $width, $height);

            if (!$thumb->save($targetName, false, 100)) {
                throw new \RuntimeException('Unable to save ' . $targetName);
            }

            if (!$thumb->save($targetName . '.webp', ImageHandler::IMG_WEBP, 100)) {
                throw new \RuntimeException('Unable to save ' . $targetName . 'webp');
            }
            return true;
        }

        return false;
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

    private function parseFilename(string $fileName): stdClass
    {
        $result = false;
        if (preg_match('|^(?P<path>' . $this->rootPath . '/[/\w]+)/(?P<name>\w+)_(?P<width>\d+)x?(?P<height>\d+)?\.(?P<ext>\w+)(\.webp)?$|', $fileName, $matches)) {
            $result = new StdClass;
            $result->path = $matches['path'];
            $result->fileName = $matches['name'];
            $result->width = $matches['width'] ?? 0;
            $result->height = $matches['height'] ?? 0;
            $result->extension = $matches['ext'];
            $result->baseName = $matches['name'] . '.' . $matches['ext'];
        }
        return $result;
    }

    private function isAllowedResolution(string $path, int $width, int $height): bool
    {
        $resolution = $width . 'x' . $height;

        foreach ($this->allowedThumbnailResolutions as $rule) {
            if (mb_strpos($path, $rule[0], null, 'UTF-8') === 0) {
                if (in_array($resolution, $rule[1], true)) {
                    return true;
                }
            }
        }
        return false;
    }
}
