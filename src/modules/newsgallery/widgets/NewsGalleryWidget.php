<?php

Yii::import('application.modules.newsgallery.models.*');

class NewsGalleryWidget extends DWidget
{
    public $tpl = 'NewsGallery';
    public $id = '';

    public function run()
    {
        $path = NewsGallery::GALLERY_PATH;

        if (!$this->id) {
            return;
        }

        $gallery = NewsGallery::model()->find([
            'condition' => 'alias = :alias',
            'params' => [':alias' => $this->id],
        ]);

        if (!$gallery && (int)$this->id) {
            $gallery = NewsGallery::model()->findByPk($this->id);
        }

        if ($gallery && file_exists($path . '/' . $gallery->alias)) {
            $this->render($this->tpl, [
                'path' => $path . '/' . $gallery->alias,
                'htmlpath' => $path . '/' . $gallery->alias,
            ]);
        }
    }
}
