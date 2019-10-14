<?php

namespace app\modules\blog\models;

use app\components\ActiveRecord;
use CActiveDataProvider;
use CDbCriteria;
use Yii;

/**
 * @property integer $id
 * @property string $title
 */
class Tag extends ActiveRecord
{
    /**
     * @return string the associated database table name
     */
    public function tableName(): string
    {
        return 'blog_tags';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules(): array
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
     * @return array relational rules.
     */
    public function relations(): array
    {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return [
            'frequency' => [self::STAT, \app\modules\blog\models\PostTag::class, 'tag_id'],
            'posttags' => [self::HAS_MANY, \app\modules\blog\models\PostTag::class, 'tag_id'],
        ];
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'title' => 'Метка',
            'frequency' => 'Число записей',
        ];
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @param int $pageSize
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search($pageSize = 10): CActiveDataProvider
    {
        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('title', $this->title, true);

        return new CActiveDataProvider($this, [
            'criteria' => $criteria,
            'pagination' => [
                'pageSize' => $pageSize,
                'pageVar' => 'page',
            ],
        ]);
    }

    protected function beforeDelete(): bool
    {
        if (parent::beforeDelete()) {
            foreach ($this->posttags as $posttag) {
                $posttag->delete();
            }
            return true;
        }
        return false;
    }

    public function getAssocList(): array
    {
        $items = $this->findAll(['order' => 'title']);
        $result = [];
        foreach ($items as $item) {
            $result[$item->id] = $item->title;
        }
        return $result;
    }

    public function findOrCreateByTitle($title): self
    {
        $tag = $this->findByTitle($title);
        if (!$tag) {
            $tag = new self();
            $tag->title = $title;
            $tag->save();
        }
        return $tag;
    }

    public function getPostIds(): array
    {
        $postIds = Yii::app()->db
            ->createCommand('SELECT post_id FROM blog_post_tags WHERE tag_id=:tag')
            ->queryColumn([':tag' => $this->id]);

        return array_unique($postIds);
    }

    public function getArrayByMatch($q): array
    {
        $titles = Yii::app()->db
            ->createCommand('SELECT title FROM blog_tags WHERE title LIKE :tag')
            ->queryColumn([':tag' => $q . '%']);

        return array_unique($titles);
    }

    public function findByTitle($title): ?self
    {
        $tag = $this->find([
            'condition' => 'title = :title',
            'params' => [':title' => $title],
        ]);

        return $tag;
    }

    private $_url;

    public function getUrl(): string
    {
        if ($this->_url === null) {
            $this->_url = Yii::app()->createUrl('/blog/default/tag', ['tag' => $this->title]);
        }

        return $this->_url;
    }
}
