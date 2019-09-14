<?php

namespace app\modules\blog\models;

use CActiveDataProvider;
use CActiveRecord;
use CDbCriteria;

/**
 * This is the model class for table "{{blog_post_tag}}".
 *
 * The followings are the available columns in table '{{blog_post_tag}}':
 * @property integer $id
 * @property integer $post_id
 * @property integer $tag_id
 */
class BlogPostTag extends CActiveRecord
{
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return BlogPostTag the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return '{{blog_post_tag}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return [
            ['post_id, tag_id', 'required'],
            ['post_id, tag_id', 'numerical', 'integerOnly' => true],
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            ['id, post_id, tag_id', 'safe', 'on' => 'search'],
        ];
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return [
            'tag' => [self::BELONGS_TO, \app\modules\blog\models\BlogTag::class, 'tag_id'],
        ];
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'post_id' => 'Post',
            'tag_id' => 'Tag',
        ];
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search()
    {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('post_id', $this->post_id);
        $criteria->compare('tag_id', $this->tag_id);

        return new CActiveDataProvider($this, [
            'criteria' => $criteria,
        ]);
    }
}
