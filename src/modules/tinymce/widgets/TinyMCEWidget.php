<?php

namespace app\modules\tinymce\widgets;

use CClientScript;
use CHtml;
use app\components\widgets\Widget;
use Yii;

class TinyMCEWidget extends Widget
{
    public function run()
    {
        $cs = Yii::app()->getClientScript();

        $url = CHtml::asset(Yii::getPathOfAlias('tinymce.assets'));

        $cs->registerCssFile($url . '/tinymce.css');
        $cs->registerScriptFile($url . '/tinymce/jquery.tinymce.js', CClientScript::POS_HEAD);
        $cs->registerScriptFile($url . '/tinymce/plugins/tinybrowser/tb_tinymce.js.php', CClientScript::POS_END);

        $scriptUrl = $url . '/tinymce/tiny_mce.js';
        $styleUrl = Yii::app()->baseUrl . '/build/tinymce.css';

        $this->render('tinymce', [
            'scriptUrl' => $scriptUrl,
            'styleUrl' => $styleUrl,
        ]);
    }
}
