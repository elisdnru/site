<?php

class ShareWidget extends DWidget
{
    public $tpl = 'default';
    public $url = '';
    public $title = '';
    public $description = '';
    public $image = '';

    public function run()
    {
        $this->initFields();

        $this->render('Share/'.$this->tpl ,array(
            'url'=>$this->url,
            'title'=>$this->title,
            'description'=>mb_substr(strip_tags($this->description), 0, 200, 'UTF-8') . '...',
            'image'=>$this->image,
        ));
    }

    protected function initFields()
    {
        if (!trim($this->url)) $this->url = $_SERVER['REQUEST_URI'] . $_SERVER['QUERY_STRING'];
        if (!trim($this->title)) $this->title = Yii::app()->controller->pageTitle;
        if (!trim($this->description)) $this->description = Yii::app()->controller->description;
        $this->url = 'http://' . $_SERVER['SERVER_NAME'] . $this->url;
        if (trim($this->image)) $this->image = 'http://' . $_SERVER['SERVER_NAME'] . $this->image;
    }
}