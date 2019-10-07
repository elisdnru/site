<?php

namespace app\modules\blog\models;

use app\components\ActiveRecord;
use CActiveDataProvider;
use CDbCriteria;

/**
 * @property integer $id
 * @property string $title
 */
class BlogPostGroup extends ActiveRecord
{
    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return '{{blog_post_group}}';
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return [
            'posts' => [self::HAS_MANY, \app\modules\blog\models\BlogPost::class, 'group_id',
                'condition' => 'posts.public=1',
                'order' => 'posts.date DESC, posts.id DESC'
            ],
            'posts_count' => [self::STAT, \app\modules\blog\models\BlogPost::class, 'group_id'],
        ];
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return [
            ['title', 'required'],
            ['title', 'length', 'max' => 255],
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            ['id, title', 'safe', 'on' => 'search'],
        ];
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Наименование группы',
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
        $criteria->compare('title', $this->title, true);

        return new CActiveDataProvider($this, [
            'criteria' => $criteria,
        ]);
    }

    public function behaviors()
    {
        return [
            'CategoryBehavior' => [
                'class' => \app\components\category\behaviors\CategoryBehavior::class,
                'titleAttribute' => 'title',
                'defaultCriteria' => [
                    'order' => 't.title ASC'
                ],
            ],
        ];
    }
}
