<?php

namespace app\modules\blog\models;

use app\components\category\behaviors\CategoryBehavior;
use app\modules\blog\models\query\GroupQuery;
use yii\db\ActiveRecord;

/**
 * @property int $id
 * @property string $title
 *
 * @mixin CategoryBehavior
 */
class Group extends ActiveRecord
{
    public static function tableName(): string
    {
        return 'blog_post_groups';
    }

    public static function find(): GroupQuery
    {
        return new GroupQuery(static::class);
    }

    public function getPostsCount(): int
    {
        return (int)Post::find()->andWhere(['group_id' => $this->id])->count();
    }

    public function rules(): array
    {
        return [
            ['title', 'required'],
            ['title', 'string', 'max' => 255],
        ];
    }

    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'title' => 'Наименование группы',
        ];
    }

    public function behaviors(): array
    {
        return [
            'CategoryBehavior' => [
                'class' => CategoryBehavior::class,
            ],
        ];
    }
}
