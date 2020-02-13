<?php

namespace app\modules\menu\models;

use app\components\category\behaviors\CategoryTreeBehavior;
use app\modules\menu\models\query\MenuQuery;
use Yii;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * @property integer $id
 * @property string $title
 * @property string $alias
 * @property string $link
 * @property integer $sort
 * @property integer $parent_id
 * @property integer $visible
 *
 * @mixin CategoryTreeBehavior
 */
class Menu extends ActiveRecord
{
    public $indent = 0;

    public static function tableName(): string
    {
        return 'menu_items';
    }

    public static function find(): MenuQuery
    {
        return new MenuQuery(static::class);
    }

    public function rules(): array
    {
        return [
            [['title', 'link', 'sort'], 'required'],
            ['alias', 'safe'],
            [['sort', 'parent_id', 'visible'], 'integer'],
        ];
    }

    public function getChildren(): ActiveQuery
    {
        return $this->hasMany(self::class, ['parent_id' => 'id'])
            ->alias('children')
            ->orderBy(['children.sort' => SORT_ASC, 'children.title' => SORT_ASC]);
    }

    public function getParent(): ActiveQuery
    {
        return $this->hasOne(self::class, ['id' => 'parent_id']);
    }

    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'title' => 'Заголовок',
            'alias' => 'Псевдоним',
            'link' => 'Ссылка',
            'sort' => 'Позиция',
            'parent_id' => 'Родительский пункт',
            'visible' => 'Видимо',
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
                'linkActiveAttribute' => 'linkActive',
                'parentRelation' => 'parent',
            ],
        ];
    }

    public function getLinkActive(): bool
    {
        $currentUri = '/' . Yii::$app->request->getPathInfo();
        $itemUri = $this->getUrl();
        return strpos('/' . $currentUri . '/', '/' . $itemUri . '/') === 0 || strpos('/' . $currentUri . '?', '/' . $itemUri . '?') === 0;
    }

    private $cachedUrl;

    public function getUrl(): string
    {
        if ($this->cachedUrl === null) {
            $this->cachedUrl = $this->link !== '/index' ? $this->link : '/';
        }

        return $this->cachedUrl;
    }
}
