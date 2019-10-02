<?php

namespace app\modules\uploader\components;

use CApplicationComponent;
use app\extensions\file\CFile;
use app\extensions\image\CImageHandler;
use CUploadedFile;
use StdClass;
use Yii;

class UploadManager extends CApplicationComponent
{
    public $rootPath = 'upload';
    public $emptyImage = '';
    public $watermarkFile = '';
    public $watermarkOffsetX = 10;
    public $watermarkOffsetY = 10;
    public $watermarkPosition = CImageHandler::CORNER_RIGHT_BOTTOM;
    public $origFileSalt = 'salt';
    public $allowedThumbnailResolutions = [];
    public $directoryRights = 755;

    public function upload(CUploadedFile $file, string $path): ?CFile
    {
        if (!is_dir($path)) {
            Yii::app()->file->set($path)->createDir($this->directoryRights);
        }

        $extension = strtolower($file->extensionName);
        $fileName = FileHelper::getRandomFileName($path, $extension);
        $baseName = $fileName . '.' . $extension;

        $main = $path . '/' . $baseName;

        if ($this->watermarkFile) {
            $orig = $path . '/' . $this->createOrigFileName($baseName);
            if ($file->saveAs($orig)) {
                $this->createThumb($path, $baseName);
                return Yii::app()->file->set($main);
            }
        } else {
            if ($file->saveAs($main)) {
                return Yii::app()->file->set($main);
            }
        }

        return null;
    }

    public function uploadByUrl($url, $path, $extension): ?CFile
    {
        $content = file_get_contents($url);

        if ($content) {
            $fileName = FileHelper::getRandomFileName($path, $extension);
            $baseName = $fileName . '.' . $extension;

            $orig = $path . '/' . $this->createOrigFileName($baseName);

            $f = fopen($orig, 'w');
            fputs($f, $content);
            fclose($f);

            return Yii::app()->file->set($orig);
        }
        return null;
    }

    public function delete($baseName, $path): bool
    {
        if (!$baseName) {
            return false;
        }

        if (!preg_match('|^' . $this->rootPath . '|s', $path)) {
            return false;
        }

        $dir = Yii::app()->file->set($path);

        if (!$dir->contents) {
            return false;
        }

        $file = Yii::app()->file->set($path . '/' . $baseName);
        $fileName = $file->filename;
        $extension = $file->extension ? '\.' . $file->extension : '';

        if (!$fileName) {
            return false;
        }

        foreach ($dir->contents as $currentFile) {
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
        $fileName = $path . '/' . $this->createOrigFileName($baseName);
        if (!file_exists($fileName)) {
            $fileName = $path . '/' . $baseName;
            $this->watermarkFile = false;
        }

        if (!file_exists($fileName)) {
            return false;
        }

        /* @var $orig CImageHandler */
        /* @var $thumb CImageHandler */

        if ($orig = Yii::app()->image->load($fileName)) {
            if ($width && $height) {
                $thumb = $orig->adaptiveThumb($width, $height);
            } else {
                $thumb = $orig->thumb($width ? $width : false, $height ? $height : false, true);
            }

            $targetName = $path . '/' . $this->createThumbFileName($baseName, $width, $height);

            if ($this->watermarkFile) {
                $thumb = $thumb->watermark($this->watermarkFile, $this->watermarkOffsetX, $this->watermarkOffsetY, $this->watermarkPosition);
            }

            if (!$thumb->save($targetName, false, 100)) {
                throw new \RuntimeException('Unable to save ' . $targetName);
            }

            if (!$thumb->save($targetName . '.webp', CImageHandler::IMG_WEBP, 100)) {
                throw new \RuntimeException('Unable to save ' . $targetName . 'webp');
            }

        }

        return false;
    }

    public function createOrigFileName(string $baseName): string
    {
        if (!$this->watermarkFile) {
            return $baseName;
        }

        if (preg_match('|^(?P<name>[\w-]+)\.(?P<extension>\w+)$|', $baseName, $matches)) {
            $fileName = $matches['name'];
            $extension = '.' . $matches['extension'];
        } else {
            $fileName = $baseName;
            $extension = '';
        }

        return $fileName . '_orig_' . $this->origFileSalt . $extension;
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

    private function parseFilename(string $fileName)
    {
        $result = false;
        if (preg_match('|^(?P<path>' . $this->rootPath . '/[/\w]+)/(?P<name>\w+)_(?P<width>\d+)x?(?P<height>\d+)?\.(?P<ext>\w+)(\.webp)?$|', $fileName, $matches)) {
            $result = new StdClass;
            $result->path = $matches['path'];
            $result->fileName = $matches['name'];
            $result->width = isset($matches['width']) ? $matches['width'] : 0;
            $result->height = isset($matches['height']) ? $matches['height'] : 0;
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
                if (in_array($resolution, $rule[1])) {
                    return true;
                }
            }
        }
        return false;
    }
}
