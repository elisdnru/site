<?php

class InterestModule extends DWebModule
{
    public function init()
    {
        parent::init();

        $this->setImport(array(
            'application.modules.interest.components.*',
            'application.modules.interest.models.*',
        ));
    }

    public function getGroup()
    {
        return 'Прочее';
    }

    public function getName()
    {
        return 'Интересное';
    }

    public static function adminMenu()
    {
        return array(
            array('label'=>'Интересное', 'url'=>array('/interest/itemAdmin/index'), 'icon'=>'foldericon.jpg'),
            array('label'=>'Добавить элемент', 'url'=>array('/interest/itemAdmin/create'), 'icon'=>'add.png'),
        );
    }

    public static function rules()
    {
        return array(
            'interest/all'=>'interest/item/all',
            'interest/<id:\d+>'=>'interest/item/show',
        );
    }

	public function install()
	{
		Yii::app()->config->add(array(
			array(
				'param'=>'INTEREST.ALL_LINK',
				'label'=>'Ссылка на все записи',
				'value'=>'',
				'type'=>'string',
				'default'=>'',
			),
		));

		return parent::install();
	}

	public function uninstall()
	{
		Yii::app()->config->delete(array(
			'INTEREST.ALL_LINK',
		));

		return parent::uninstall();
	}
}
