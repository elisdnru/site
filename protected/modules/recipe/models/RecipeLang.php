<?php

Yii::import('application.modules.recipe.models.Recipe');

class RecipeLang extends CActiveRecord
{
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }

    public function tableName()
    {
        return '{{recipe_lang}}';
    }

    public function relations()
    {
        return array('Recipe' => array(self::BELONGS_TO, 'Recipe', 'owner_id'));
    }

    public function behaviors()
    {
        return array(
            'PurifyShort'=>array(
                'class'=>'DPurifyTextBehavior',
                'sourceAttribute'=>'l_short',
                'destinationAttribute'=>'l_short_purified',
                'purifierOptions'=> array(
                    'Attr.AllowedRel'=>array('nofollow'),
					'HTML.Nofollow' => true,
                ),
                'processOnBeforeSave'=>true,
            ),
            'PurifyText'=>array(
                'class'=>'DPurifyTextBehavior',
                'sourceAttribute'=>'l_text',
                'destinationAttribute'=>'l_text_purified',
                'enableMarkdown'=>true,
                'enablePurifier'=>true,
                'purifierOptions'=> array(
					'Attr.AllowedRel'=>array('nofollow'),
					'HTML.SafeObject'=>true,
					'Output.FlashCompat'=>true,
					'HTML.SafeIframe'=>true,
					'URI.SafeIframeRegexp'=>'%^(https?:)?//(www\.youtube(?:-nocookie)?\.com/embed/|player\.vimeo\.com/video/)%',
                ),
                'processOnBeforeSave'=>true,
            ),
        );
    }
}
