<?php

Yii::import('application.modules.callme.models.*');
DUrlRulesHelper::import('callme');

class CallmeWidget extends DWidget
{
    public $tpl = 'default';

	public function run()
	{
        $form = new CallmeForm();

		$this->render('Callme/'.$this->tpl ,array(
            'model'=>$form,
        ));
	}
}