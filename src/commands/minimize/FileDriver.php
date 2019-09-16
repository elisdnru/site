<?php

declare(strict_types=1);

namespace app\commands\minimize;

use app\commands\Exception;
use app\commands\minimize;
use Yii;

class FileDriver implements minimize\Driver
{
    private $path;

    public function __construct()
    {
        $this->path = Yii::getPathOfAlias('application');
    }

    public function load($file)
    {
        $path = $this->getFullPath($file);
        $contents = @call_user_func_array('file_get_contents', [$path]);
        if ($contents === false) {
            throw new Exception('Failed to open ' . $file);
        } else {
            return $contents;
        }
    }

    public function save($file, $text)
    {
        $path = $this->getFullPath($file);
        $contents = @call_user_func_array('file_put_contents', [$path, $text]);
        if ($contents === false) {
            throw new Exception('Failed to write to ' . $file);
        }
    }

    private function getFullPath($filename)
    {
        $file = $this->path . '/' . $filename;
        return preg_replace('#[/\\\\]#', DIRECTORY_SEPARATOR, $file);
    }
}
