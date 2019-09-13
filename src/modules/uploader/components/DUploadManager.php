<?php

namespace app\modules\uploader\components;

use CApplicationComponent;
use CFile;
use CImageHandler;
use CUploadedFile;
use StdClass;
use Yii;

class DUploadManager extends CApplicationComponent
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

    /**
     * @param CUploadedFile $file
     * @param string $path
     * @return bool|CFile
     */
    public function upload(CUploadedFile $file, $path)
    {
        if (!is_dir($path)) {
            Yii::app()->file->set($path)->createDir($this->directoryRights);
        }

        $extension = strtolower($file->extensionName);
        $fileName = DFileHelper::getRandomFileName($path, $extension);
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

        return false;
    }

    /**
     * @param string $url
     * @param string $path
     * @param string $extension
     * @return bool|CFile
     */
    public function uploadByUrl($url, $path, $extension)
    {
        $content = file_get_contents($url);

        if ($content) {
            $fileName = DFileHelper::getRandomFileName($path, $extension);
            $baseName = $fileName . '.' . $extension;

            $orig = $path . '/' . $this->createOrigFileName($baseName);

            $f = fopen($orig, 'w');
            fputs($f, $content);
            fclose($f);

            return Yii::app()->file->set($orig);
        } else {
            return false;
        }
    }

    /**
     * @param string $baseName
     * @param string $path
     * @return bool
     */
    public function delete($baseName, $path)
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

    /**
     * @param string $path
     * @param string $baseName
     * @return string
     */
    public function getUrl($path, $baseName)
    {
        if (!$baseName) {
            return $this->emptyImage;
        }

        if (!file_exists($path . '/' . $baseName)) {
            $this->createThumb($path, $baseName);
        }

        return $path . '/' . $baseName;
    }

    /**
     * @param string $path
     * @param string $baseName
     * @param integer $width
     * @param integer $height
     * @return string
     */
    public function getThumbUrl($path, $baseName, $width = 0, $height = 0)
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

    /**
     * @param string $fileName
     * @return bool|CFile
     */
    public function checkThumbExists($fileName)
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

        if (!$file = $this->createThumb($requested->path, $requested->baseName, $requested->width, $requested->height)) {
            return false;
        }

        return $file;
    }

    /**
     * @param $path
     * @param $baseName
     * @param bool $width
     * @param bool $height
     * @return bool|CFile
     */
    public function createThumb($path, $baseName, $width = 0, $height = 0)
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

            if ($thumb->save($targetName, false, 100)) {
                return Yii::app()->file->set($targetName);
            }
        }

        return false;
    }

    public function createOrigFileName($baseName)
    {
        if (!$this->watermarkFile) {
            return $baseName;
        }

        if (preg_match('|^(?P<name>[\w\d_-]+)\.(?P<extension>[\w\d]+)$|s', $baseName, $matches)) {
            $fileName = $matches['name'];
            $extension = '.' . $matches['extension'];
        } else {
            $fileName = $baseName;
            $extension = '';
        }

        return $fileName . '_orig_' . $this->origFileSalt . $extension;
    }

    public function createThumbFileName($baseName, $width, $height)
    {
        if ($width || $height) {
            if (preg_match('|^(?P<name>[\w\d_-]+)\.(?P<extension>[\w\d]+)$|s', $baseName, $matches)) {
                $fileName = $matches['name'];
                $extension = '.' . $matches['extension'];
            } else {
                $fileName = $baseName;
                $extension = '';
            }

            return $fileName . '_' . (int)$width . 'x' . (int)$height . $extension;
        } else {
            return $baseName;
        }
    }

    protected function parseFilename($fileName)
    {
        $result = false;
        if (preg_match('|^(?P<path>' . $this->rootPath . '/[/\w\d]+)/(?P<name>[\w\d]+)_(?P<width>\d+)x?(?P<height>\d+)?\.(?P<ext>[\w\d]+)$|is', $fileName, $matches)) {
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

    protected function isAllowedResolution($path, $width, $height)
    {
        $resolution = (int)$width . 'x' . (int)$height;

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
