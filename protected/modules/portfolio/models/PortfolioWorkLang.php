<?php

Yii::import('application.modules.portfolio.models.PortfolioWork');

class PortfolioWorkLang extends CActiveRecord
{
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }

    public function tableName()
    {
        return '{{portfolio_work_lang}}';
    }

    public function relations()
    {
        return array('PortfolioWork' => array(self::BELONGS_TO, 'PortfolioWork', 'owner_id'));
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
                ),
                'processOnBeforeSave'=>true,
            ),
        );
    }
}
