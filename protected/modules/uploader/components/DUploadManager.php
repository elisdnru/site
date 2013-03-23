<?php

Yii::import('application.modules.uploader.components.*');

/**
 * @author ElisDN <mail@elisdn.ru>
 * @link http://www.elisdn.ru
 */
class DUploadManager extends CApplicationComponent
{
    public $rootPath = 'upload';
    public $emptyImage = '';
    public $allowedThumbnailResolutions = array();

    /**
     * @param CUploadedFile $file
     * @param string $path
     * @return bool|CFile
     */
    public function upload(CUploadedFile $file, $path)
    {
        if (!is_dir($path)){
            Yii::app()->file->set($path)->createDir(755);
        }

        $extension = strtolower($file->extensionName);
        $filename = DFileHelper::getRandomFileName($path, $extension);
        $basename =  $filename . '.' . $extension;

        $orig = $path . '/' . $basename;


        if ($file->saveAs($orig))
            return Yii::app()->file->set($orig);
        else
            return false;
    }

    /**
     * @param CUploadedFile $file
     * @param string $path
     * @return bool|CFile
     */
    public function uploadByUrl($url, $path, $extension)
    {
        $content = file_get_contents($url);

        if ($content)
        {
            $filename = DFileHelper::getRandomFileName($path, $extension);
            $basename =  $filename . '.' . $extension;

            $orig = $path . '/' . $basename;

            $f = fopen($orig, 'w');
            fputs($f, $content);
            fclose($f);

            return Yii::app()->file->set($orig);
        }
        else
            return false;
    }

    /**
     * @param string $baseName
     * @param string $path
     * @return bool
     */
    public function delete($baseName, $path)
    {
        if (!$baseName)
            return false;

        if (!preg_match('|^' . $this->rootPath . '|s', $path))
            return false;

        $dir = Yii::app()->file->set($path);

        if (!$dir->contents)
            return false;

        $file = Yii::app()->file->set($path . '/' . $baseName);
        $fileName = $file->filename;
        $extension = $file->extension ? '\.' . $file->extension : '';

        if (!$fileName)
            return false;

        foreach ($dir->contents as $currentFile)
        {
            if (preg_match('|^' . $fileName . '.*' . $extension . '$|s', basename($currentFile)))
                @unlink($currentFile);
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
        return $baseName ? $path . '/' . $baseName : '';
    }

    /**
     * @param string $path
     * @param string $baseName
     * @param integer $width
     * @param integer $height
     * @return string
     */
    public function getThumbUrl($path, $baseName, $width=0, $height=0)
    {
        if (!$baseName)
            return $this->emptyImage;

        if (!$this->isAllowedResolution($path, $width, $height))
            return '';

        $baseName = $this->createThumbFileName($baseName, $width, $height);

        return $baseName ? $path . '/' . $baseName : '';
    }

    /**
     * @param string $fileName
     * @return bool|CFile
     */
    public function checkThumbExists($fileName)
    {
        if (file_exists($fileName))
            return true;

        if (!$requested = $this->parseFileName($fileName))
            return false;

        if (!$this->isAllowedResolution($requested->path, $requested->width, $requested->height))
            return false;

        if (!$file = $this->createThumb($requested->path, $requested->baseName, $requested->width, $requested->height))
            return false;

        return $file;
    }

    /**
     * @param $path
     * @param $baseName
     * @param bool $width
     * @param bool $height
     * @return bool|CFile
     */
    public function createThumb($path, $baseName, $width=0, $height=0)
    {
        $fileName = $path . '/' . $baseName;
        if (!file_exists($fileName))
            return false;

        if ($orig = Yii::app()->image->load($fileName))
        {
            if ($width && $height)
                $orig = $orig->adaptiveThumb($width, $height);
            else
                $orig = $orig->thumb($width ? $width : false, $height ? $height : false, true);

            $targetName = $path . '/' . $this->createThumbFileName($baseName, $width, $height);

            if ($orig->save($targetName, false, 100))
                return Yii::app()->file->set($targetName);
        }

        return false;
    }

    public function createThumbFileName($baseName, $width, $height)
    {
        if (preg_match('|^(?P<name>[\w\d_-]+)\.(?P<extension>[\w\d]+)$|s', $baseName, $matches))
        {
            $fileName = $matches['name'];
            $extension = '.' . $matches['extension'];
        }
        else
        {
            $fileName = $baseName;
            $extension = '';
        }

        return $fileName . '_' . (int)$width . 'x' . (int)$height . $extension;
    }

    protected function parseFilename($fileName)
    {
        $result = false;
        if (preg_match('|^(?P<path>' . $this->rootPath . '/[/\w\d]+)/(?P<name>[\w\d]+)_(?P<width>\d+)x?(?P<height>\d+)?\.(?P<ext>[\w\d]+)$|is', $fileName, $matches))
        {
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
        $resolutions = array();
        foreach ($this->allowedThumbnailResolutions as $rule)
        {
            if (mb_strpos($rule[0], $path, null, 'UTF-8') === 0)
                $resolutions = array_merge($resolutions, $rule[1]);
        }
        return in_array((int)$width . 'x' . (int)$height, array_unique($resolutions));
    }
}
