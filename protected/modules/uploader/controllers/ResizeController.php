<?php

class ResizeController extends DController
{
    public function actionIndex()
    {
        ini_set('memory_limit', '512M');
        ini_set('max_execution_time', '300');

        $root = Yii::getPathOfAlias('webroot');
        $path = $root . '/upload/images/shop';

        $dir = Yii::app()->file->set($path);

        $i = 0;

        $prefix = 'p_';

        foreach ($dir->contents as $item) {

            /** @var $file CFile */
            $file = Yii::app()->file->set($item);
            if ($file->getBasename() == '.htaccess') continue;
            if (substr($file->getBasename(), 0, strlen($prefix)) == $prefix) continue;
            if (file_exists($path . '/' . $prefix . $file->getBasename())) {
                $basename = $file->getBasename();
                if ($file->delete()){
                    echo 'Delete ' . $basename . ' <br />';
                    rename($path . '/' . $prefix . $basename, $path . '/' . $basename);
                }
                continue;
            }

            try {
                echo $file->getBasename() . ' <br />';
                /** @var $orig CImageHandler */
                if ($orig = Yii::app()->image->load($path . '/' . $file->getBasename()))
                {
                    $width = false;
                    $height = false;

                    if ($orig->getWidth() > $orig->getHeight() && $orig->getWidth() > 1000){
                        $width = 1000;
                    } elseif ($orig->getHeight() > $orig->getWidth() && $orig->getHeight() > 1000){
                        $height = 1000;
                    }

                    if ($width || $height){
                        if ($i++ > 50) break;
                        $orig = $orig->thumb($width, $height, true);

                        $targetName = $prefix . $file->getBasename();

                        if ($orig->save($path . '/' . $targetName, false, 100)){
                            echo $targetName . ' - processed<br />';
                        }
                    }
                }
            } catch (Exception $e){
                echo $file->getBasename() . ': ' . $e->getMessage() . ' <br />';
                continue;
            }
        }
    }
}