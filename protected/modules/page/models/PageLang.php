<?php

Yii::import('page.models.Page');

class PageLang extends CActiveRecord
{
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }

    public function tableName()
    {
        return '{{page_lang}}';
    }

    public function relations()
    {
        return array('Page' => array(self::BELONGS_TO, 'Page', 'page_id'));
    }

    public function behaviors()
    {
        return array(
            'PurifyText'=>array(
                'class'=>'DPurifyTextBehavior',
                'sourceAttribute'=>'l_text',
                'destinationAttribute'=>'l_text_purified',
                'purifierOptions'=> array(
                    'HTML.SafeObject'=>true,
                    'Output.FlashCompat'=>true,
                ),
                'processOnBeforeSave'=>true,
            ),
        );
    }
}
