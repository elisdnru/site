<?php

Yii::import('slideshow.models.*');

class SlideshowWidget extends DWidget
{
    public $items;

    public $options = array(
        'pause' => 5000,
        'continuous' => true,
        'controlsShow' => false
    );

    public function run()
    {
        $this->registerScripts();
        $items = $this->loadItems($this->items);

        if (!isset($this->options['auto']))
            $this->options['auto'] = count($items) > 1 ? true : false;

        $this->render('Slideshow', array(
            'items'=>$items,
            'options'=>$this->options,
        ));
    }

    protected function loadItems($sourceItems = null)
    {
        if ($sourceItems === null)
        {
            $items = array();

            $slides = Slide::model()->findAll(array('order' => 'sort ASC'));
            foreach ($slides as $slide)
            {
                $items[] = array(
                    'title' => $slide->title,
                    'text' => $slide->text,
                    'image' => $slide->imageUrl,
                    'url' => $slide->url,
                );
            }
        }
        else
            $items = $sourceItems;

        return $items;
    }

    public function registerScripts()
	{
		$cs = Yii::app()->getClientScript();
        $cs->registerCoreScript('jquery');
        $url = CHtml::asset(Yii::getPathOfAlias('slideshow.assets'));
		$cs->registerScriptFile($url . '/easySlider.js', CClientScript::POS_HEAD);
	}
}