<?php

Yii::import('application.modules.block.models.*');

class BlockWidget extends DWidget
{
    public $tpl = 'default';
	public $id = '';

	public function run()
	{
        if (!$this->id)
            echo ('<div class="flash-error">[*block|id=?*]</div>');

        $model = Block::model()->cache(1000)->find('alias=:alias', array('alias'=>$this->id));
        if (!$model)
            return false;

        echo $model->text;
	}

}