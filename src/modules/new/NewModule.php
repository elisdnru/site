<?php

class NewModule extends DWebModule
{
    public function init()
    {
        parent::init();

        $this->setImport(array(
            'application.modules.new.models.*',
        ));
    }

    public static function system()
    {
        return true;
    }

    public function getGroup()
    {
        return 'Контент';
    }

    public function getName()
    {
        return 'Новости';
    }

    public static function adminMenu()
    {
        return array(
            array('label'=>'Новостные страницы', 'url'=>array('/new/pageAdmin'), 'icon'=>'foldericon.jpg'),
            array('label'=>'Темы', 'url'=>array('/new/groupAdmin'), 'icon'=>'foldericon.jpg'),
            array('label'=>'Новости/Статьи', 'url'=>array('/new/newAdmin'), 'icon'=>'fileicon.jpg'),
            array('label'=>'Добавить новость', 'url'=>array('/new/newAdmin/create'), 'icon'=>'add.png'),
        );
    }

    public static function notifications()
    {
        if (!Yii::app()->moduleManager->active('comment'))
            return array();

        $comments = NewsComment::model()->count(array(
            'condition'=>'moder=0 AND type=:type',
            'params'=>array(':type'=>NewsComment::TYPE_OF_COMMENT),
        ));

        return array(
            array('label'=>'Комментарии к новостям' . ($comments ?  ' (' . $comments . ')' : ''), 'url'=>array('/new/commentAdmin/index'), 'icon'=>'comments.png'),
        );
    }

    public static function rules()
    {
        return array(
            'new/feed'=>'new/feed/index',
            array('class' => 'new.components.DNewUrlRule', 'cache'=>3600*24),
        );
    }

    public function install()
    {
        Yii::app()->config->add(array(
            array(
                'param'=>'NEW.NEWS_PER_PAGE',
                'label'=>'Новостей на странице',
                'value'=>'10',
                'type'=>'string',
                'default'=>'10',
            ),
            array(
                'param'=>'NEW.NEWS_PER_HOME',
                'label'=>'Новостей на главной странице',
                'value'=>'10',
                'type'=>'string',
                'default'=>'10',
            ),
        ));

        return parent::install();
    }

    public function uninstall()
    {
        Yii::app()->config->delete(array(
            'NEW.NEWS_PER_PAGE',
            'NEW.NEWS_PER_HOME',
        ));

        return parent::uninstall();
    }
}