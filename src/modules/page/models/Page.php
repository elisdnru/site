<?php

declare(strict_types=1);

namespace app\modules\page\models;

use app\components\category\behaviors\CategoryTreeBehavior;
use app\components\ForceActiveRecordErrors;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * @property int $id
 * @property string $slug
 * @property string $title
 * @property bool $hidetitle
 * @property string $meta_title
 * @property string $meta_description
 * @property string $robots
 * @property string $styles
 * @property string $text
 * @property string $layout
 * @property string $subpages_layout
 * @property int|null $parent_id
 * @property bool $system
 *
 * @property Page[] $children
 * @property Page|null $parent
 *
 * @mixin CategoryTreeBehavior
 */
final class Page extends ActiveRecord
{
    use ForceActiveRecordErrors;

    public const string INDEX_FOLLOW = 'index, follow';
    public const string INDEX_NOFOLLOW = 'index, nofollow';
    public const string NOINDEX_FOLLOW = 'noindex, follow';
    public const string NOINDEX_NOFOLLOW = 'noindex, nofollow';

    public const array LAYOUTS = [
        'default' => 'По умолчанию',
        'fullscreen' => 'Во всю ширину',
        'leftcolumn' => 'Колонка с левым сайдбаром',
        'rightcolumn' => 'Колонка с правым сайдбаром',
        'blank' => 'Полноэкранный без контейнера',
    ];

    public const array SUBPAGES_LAYOUTS = [
        'default' => 'Не отображать (по умолчанию)',
        'tabs' => 'Взаимные вкладки',
        'tabschild' => 'Дочерние вкладки',
    ];

    public int $indent = 0;

    public static function tableName(): string
    {
        return 'pages';
    }

    public static function find(): PageQuery
    {
        return new PageQuery(self::class);
    }

    /**
     * @psalm-api
     */
    public function getChildren(): ActiveQuery
    {
        return $this->hasMany(self::class, ['parent_id' => 'id'])
            ->alias('children')
            ->orderBy(['children.title' => SORT_ASC]);
    }

    /**
     * @psalm-api
     */
    public function getParent(): ActiveQuery
    {
        return $this->hasOne(self::class, ['id' => 'parent_id']);
    }

    public function behaviors(): array
    {
        return [
            'CategoryBehavior' => [
                'class' => CategoryTreeBehavior::class,
                'titleAttribute' => 'title',
                'slugAttribute' => 'slug',
                'parentAttribute' => 'parent_id',
                'parentRelation' => 'parent',
            ],
        ];
    }

    public static function robotsList(): array
    {
        return [
            self::INDEX_FOLLOW => self::INDEX_FOLLOW,
            self::INDEX_NOFOLLOW => self::INDEX_NOFOLLOW,
            self::NOINDEX_FOLLOW => self::NOINDEX_FOLLOW,
            self::NOINDEX_NOFOLLOW => self::NOINDEX_NOFOLLOW,
        ];
    }

    public function isIndexed(): bool
    {
        return \in_array($this->robots, [self::INDEX_FOLLOW, self::INDEX_NOFOLLOW], true);
    }

    public function beforeDelete(): bool
    {
        if (parent::beforeDelete()) {
            $this->delChildPages();
            return true;
        }
        return false;
    }

    private function delChildPages(): void
    {
        foreach ($this->children as $child) {
            $child->delete();
        }
    }
}
