<?php

namespace app\modules\landing\models;

use app\components\category\behaviors\CategoryTreeBehavior;
use app\modules\landing\models\query\LandingQuery;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\helpers\Url;

/**
 * @property integer $id
 * @property string $alias
 * @property string $title
 * @property string $text
 * @property integer $parent_id
 * @property integer $system
 *
 * @property Landing[] $children
 *
 * @mixin CategoryTreeBehavior
 */
class Landing extends ActiveRecord
{
    public int $indent = 0;

    public static function tableName(): string
    {
        return 'landings';
    }

    public static function find(): LandingQuery
    {
        return new LandingQuery(static::class);
    }

    public function rules(): array
    {
        return [
            [['alias', 'title'], 'required'],
            ['alias', 'match', 'pattern' => '#^\w[a-zA-Z0-9_-]+$#', 'message' => 'Допустимы только латинские символы, цифры и знак подчёркивания'],
            [['alias', 'title'], 'string', 'max' => 255],
            [['parent_id'], 'integer'],
            [['text', 'system'], 'safe'],
        ];
    }

    public function getChildren(): ActiveQuery
    {
        return $this->hasMany(self::class, ['parent_id' => 'id'])
            ->alias('children')
            ->orderBy(['children.title' => SORT_ASC]);
    }

    public function getParent(): ActiveQuery
    {
        return $this->hasOne(self::class, ['id' => 'parent_id']);
    }

    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'alias' => 'URL транслитом',
            'title' => 'Заголовок',
            'system' => 'Системный',
            'text' => 'Текст',
            'parent_id' => 'Родительский лендинг',
        ];
    }

    public function behaviors(): array
    {
        return [
            'CategoryBehavior' => [
                'class' => CategoryTreeBehavior::class,
                'titleAttribute' => 'title',
                'aliasAttribute' => 'alias',
                'parentAttribute' => 'parent_id',
                'parentRelation' => 'parent',
            ],
        ];
    }

    private ?string $cachedUrl = null;

    public function getUrl(): string
    {
        if ($this->cachedUrl === null) {
            $this->cachedUrl = Url::to(['/landing/landing/show', 'path' => $this->getPath()]);
        }
        return $this->cachedUrl;
    }

    public function beforeSave($insert): bool
    {
        if (parent::beforeSave($insert)) {
            if (!$this->parent_id) {
                $this->parent_id = null;
            }
            return true;
        }
        return false;
    }

    public function beforeDelete(): bool
    {
        if (parent::beforeDelete()) {
            $this->delChildLandings();
            return true;
        }
        return false;
    }

    private function delChildLandings(): void
    {
        foreach ($this->children as $child) {
            $child->delete();
        }
    }
}
