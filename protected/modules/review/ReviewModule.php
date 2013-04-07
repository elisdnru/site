<?php

class ReviewModule extends DWebModule
{

    public function init()
    {
        parent::init();

        $this->setImport(array(
            'application.modules.review.models.*',
        ));
    }

    public function getGroup()
    {
        return 'Контент';
    }

    public function getName()
    {
        return 'Отзывы';
    }

    public static function adminMenu()
    {
        return array(
            array('label'=>'Отзывы', 'url'=>array('/review/reviewAdmin/index'), 'icon'=>'fileicon.jpg'),
            array('label'=>'Добавить отзыв', 'url'=>array('/review/reviewAdmin/create'), 'icon'=>'add.png'),
        );
    }

    public static function rules()
    {
        return array(
            'reviews/captcha'=>'reviews/captcha',
            'reviews'=>'review/default/index',
            'reviews/<id:[\d]+>'=>'review/review/show',
        );
    }
}
