<?php

class CoinsliderWidget extends DWidget
{
    public $path = 'upload/media/slideshow';

    public $width = 640;
    public $height = 480;

    public function run()
    {
        $root = Yii::getPathOfAlias('webroot'). '/';
        $webPath = Yii::app()->request->baseUrl . '/' . $this->path;

        $this->registerScripts();

        $dir = Yii::app()->file->set($root . $this->path);

        $this->render('Coinslider', array(
            'files'=>$dir->contents,
            'path'=>$webPath,
            'width'=>$this->width,
            'height'=>$this->height,
        ));
    }

	public function registerScripts()
	{
		$cs = Yii::app()->getClientScript();

        $cs->registerCoreScript('jquery');
        $cs->registerScriptFile('jquery.easing.js');

        $url = CHtml::asset(Yii::getPathOfAlias('coinslider.assets'));

        $cs->registerCssFile($url . '/coin-slider-styles.css');
		$cs->registerScriptFile($url . '/coin-slider.min.js', CClientScript::POS_HEAD);
	}
}