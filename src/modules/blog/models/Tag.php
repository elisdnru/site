<?php

namespace app\modules\blog\models;

use Yii;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\helpers\Url;

/**
 * @property integer $id
 * @property string $title
 * @property PostTag[] $postTags
 */
class Tag extends ActiveRecord
{
    public static function tableName(): string
    {
        return 'blog_tags';
    }

    public function rules(): array
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return [
            ['title', 'required'],
            ['title', 'string', 'max' => 255],
        ];
    }

    public function getFrequency(): int
    {
        return (int)PostTag::find()->andWhere(['tag_id' => $this->id])->count();
    }

    public function getPostTags(): ActiveQuery
    {
        return $this->hasMany(PostTag::class, ['tag_id' => 'id']);
    }

    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'title' => 'Метка',
            'frequency' => 'Число записей',
        ];
    }

    public function beforeDelete(): bool
    {
        if (parent::beforeDelete()) {
            foreach ($this->postTags as $postTag) {
                $postTag->delete();
            }
            return true;
        }
        return false;
    }

    public function getAssocList(): array
    {
        $items = self::findAll(['order' => 'title']);
        $result = [];
        foreach ($items as $item) {
            $result[$item->id] = $item->title;
        }
        return $result;
    }

    public static function findOrCreateByTitle(string $title): self
    {
        $tag = self::findOne(['title' => $title]);
        if (!$tag) {
            $tag = new self();
            $tag->title = $title;
            $tag->save();
        }
        return $tag;
    }

    public function getPostIds(): array
    {
        $postIds = Yii::$app->db
            ->createCommand('SELECT post_id FROM blog_post_tags WHERE tag_id=:tag', [':tag' => $this->id])
            ->queryColumn();

        return array_unique($postIds);
    }

    private ?string $cachedUrl = null;

    public function getUrl(): string
    {
        if ($this->cachedUrl === null) {
            $this->cachedUrl = Url::to(['/blog/default/tag', 'tag' => $this->title]);
        }

        return $this->cachedUrl;
    }
}
