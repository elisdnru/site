<?php

class BooksruModule extends DWebModule
{
    public function init()
    {
        parent::init();

        $this->setImport(array(
            'application.modules.booksru.components.*',
            'application.modules.booksru.models.*',
        ));
    }

    public function getGroup()
    {
        return 'Прочее';
    }

    public function getName()
    {
        return 'BooksRu';
    }

    public static function adminMenu()
    {
        return array(
            array('label'=>'Книги', 'url'=>array('/booksru/bookAdmin/index'), 'icon'=>'foldericon.jpg'),
            array('label'=>'Добавить книгу', 'url'=>array('/booksru/bookAdmin/create'), 'icon'=>'add.png'),
        );
    }

    public static function rules()
    {
        return array(
            'booksru/all'=>'booksru/book/all',
            'booksru/book/<code:\w+>'=>'booksru/book/show',
        );
    }

    public function install()
    {
        Yii::app()->config->add(array(
            array(
                'param'=>'BOOKSRU.PARTNER_ID',
                'label'=>'Код партнёра',
                'value'=>'0',
                'type'=>'string',
                'default'=>'0',
            ),
        ));

        return parent::install();
    }

    public function uninstall()
    {
        Yii::app()->config->delete(array(
            'BOOKSRU.PARTNER_ID',
        ));

        return parent::uninstall();
    }
}
