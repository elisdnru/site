<?php

Yii::import('application.modules.personnel.models.PersonnelEmployee');

class PersonnelEmployeeLang extends CActiveRecord
{
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }

    public function tableName()
    {
        return '{{personnel_employee_lang}}';
    }

    public function relations()
    {
        return array('PersonnelEmployee' => array(self::BELONGS_TO, 'PersonnelEmployee', 'owner_id'));
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
