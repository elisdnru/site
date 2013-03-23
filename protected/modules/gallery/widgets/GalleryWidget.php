<?php

Yii::import('gallery.models.*');

class GalleryWidget extends DWidget
{
    public $tpl = 'Gallery';
    public $id = '';

    public function run()
    {
        $path = Gallery::GALLERY_PATH;

        if (!$this->id)
            return;

        $gallery = Gallery::model()->find(array(
            'condition'=>'alias = :alias',
            'params'=>array(':alias'=>$this->id),
        ));

        if (!$gallery && (int)$this->id)
            $gallery = Gallery::model()->findByPk($this->id);

        if ($gallery && file_exists($path.'/'.$gallery->alias))
        {
            $this->render($this->tpl ,array(
                'path'=>$path.'/'.$gallery->alias,
                'htmlpath'=>$path.'/'.$gallery->alias,
            ));
        }
    }
}