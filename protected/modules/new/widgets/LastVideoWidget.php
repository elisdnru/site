<?php

Yii::import('new.models.*');
Yii::import('page.models.*');

class LastVideoWidget extends DWidget
{
    public $tpl = 'LastVideo';
    public $page = '';
    public $width = 640;

    public function run()
    {
        if (!$this->page) return false;

        if (!$this->page instanceof Page)
            $page = Page::model()->findByPath($this->page);
        else
            $page = $this->page;

        if (!$page) return false;

        $new = News::model()->published()->find(array(
            'condition'=>'page_id=:p',
            'params'=>array(':p'=>$page->id),
            'limit'=>1,
            'order'=>'date DESC'
        ));

        if (!$new)
            return false;

        if (preg_match('|<object.+<\/object>|i', $new->text, $m) || preg_match('|<iframe.+<\/iframe>|i', $new->text, $m)){

            $video = $m[0];

            if (preg_match('|width=\"(\d+)\"|i', $new->text, $m)) $orig_width = $m[1]; else $orig_width = 460;
            if (preg_match('|height=\"(\d+)\"|i', $new->text, $m)) $orig_height = $m[1]; else $orig_height = 300;

            $width = $this->width;
            $height = $orig_height / $orig_width * $this->width;

            $video = str_replace($orig_width, $width, $video);
            $video = str_replace($orig_height, $height, $video);

        } else {

            $video = $new->text;
            $width = $this->width;
            $height = 300;

        }

        $this->render($this->tpl ,array(
            'video'=>$video,
            'width'=>$width,
            'height'=>$height,
        ));
    }

}