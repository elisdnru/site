<?php

Yii::import('application.modules.page.models.Page');

class PageLang extends CActiveRecord
{
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function tableName()
    {
        return '{{page_lang}}';
    }

    public function relations()
    {
        return ['Page' => [self::BELONGS_TO, 'Page', 'page_id']];
    }

    public function behaviors()
    {
        return [
            'PurifyText' => [
                'class' => 'DPurifyTextBehavior',
                'sourceAttribute' => 'l_text',
                'destinationAttribute' => 'l_text_purified',
                'purifierOptions' => [
                    'Attr.AllowedRel' => ['nofollow'],
                    'HTML.SafeObject' => true,
                    'Output.FlashCompat' => true,
                    'HTML.SafeIframe' => true,
                    'URI.SafeIframeRegexp' => '%^(https?:)?//(www\.youtube(?:-nocookie)?\.com/embed/|player\.vimeo\.com/video/)%',
                ],
                'processOnBeforeSave' => true,
            ],
        ];
    }
}
