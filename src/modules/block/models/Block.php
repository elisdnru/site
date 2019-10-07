<?php

namespace app\modules\block\models;

use app\components\ActiveRecord;
use CActiveDataProvider;
use CDbCriteria;

/**
 * @property integer $id
 * @property string $alias
 * @property string $title
 * @property string $text
 */
class Block extends ActiveRecord
{
    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'blocks';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return [
            ['alias, title', 'required'],
            ['alias, title', 'required'],
            ['alias, title', 'length', 'max' => 255],
            ['alias', 'match', 'pattern' => '#^\w[a-zA-Z0-9_-]+$#', 'message' => 'Допустимы только латинские символы, цифры и знак подчёркивания'],
            ['alias', 'unique', 'caseSensitive' => false, 'message' => 'Такой {attribute} уже используется'],
            ['text, short', 'safe'],
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            ['id, alias, title, text', 'safe', 'on' => 'search'],
        ];
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return [];
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'alias' => 'Псевдоним',
            'title' => 'Наименование',
            'text' => 'Содержимое',
        ];
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @param int $pageSize
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search($pageSize = 10)
    {
        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('alias', $this->alias, true);
        $criteria->compare('title', $this->title, true);
        $criteria->compare('text', $this->text, true);

        return new CActiveDataProvider($this, [
            'criteria' => $criteria,
            'pagination' => [
                'pageSize' => $pageSize,
                'pageVar' => 'page',
            ],
        ]);
    }
}
