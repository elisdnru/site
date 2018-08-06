<?php

Yii::import('application.modules.new.models.News');

class NewsLang extends CActiveRecord
{
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function tableName()
    {
        return '{{new_lang}}';
    }

    public function relations()
    {
        return ['News' => [self::BELONGS_TO, 'News', 'owner_id']];
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
                    'HTML.Nofollow' => true,
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
                    'HTML.SafeIframe' => true,
                    'URI.SafeIframeRegexp' => '%^(https?:)?//(www\.youtube(?:-nocookie)?\.com/embed/|player\.vimeo\.com/video/)%',
                ],
                'processOnBeforeSave' => true,
            ],
        ];
    }
}
