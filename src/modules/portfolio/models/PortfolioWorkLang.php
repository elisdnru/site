<?php

Yii::import('application.modules.portfolio.models.PortfolioWork');

class PortfolioWorkLang extends CActiveRecord
{
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function tableName()
    {
        return '{{portfolio_work_lang}}';
    }

    public function relations()
    {
        return ['PortfolioWork' => [self::BELONGS_TO, 'PortfolioWork', 'owner_id']];
    }

    public function behaviors()
    {
        return [
            'PurifyShort' => [
                'class' => 'DPurifyTextBehavior',
                'sourceAttribute' => 'l_short',
                'destinationAttribute' => 'l_short_purified',
                'purifierOptions' => [
                    'Attr.AllowedRel' => ['nofollow'],
                ],
                'processOnBeforeSave' => true,
            ],
            'PurifyText' => [
                'class' => 'DPurifyTextBehavior',
                'sourceAttribute' => 'l_text',
                'destinationAttribute' => 'l_text_purified',
                'enableMarkdown' => true,
                'enablePurifier' => true,
                'purifierOptions' => [
                    'Attr.AllowedRel' => ['nofollow'],
                    'HTML.SafeObject' => true,
                    'Output.FlashCompat' => true,
                ],
                'processOnBeforeSave' => true,
            ],
        ];
    }
}
