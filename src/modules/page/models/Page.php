<?php

namespace app\modules\page\models;

use app\components\category\behaviors\CategoryTreeBehavior;
use app\components\purifier\PurifyTextBehavior;
use app\components\Slugger;
use app\modules\page\models\query\PageQuery;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\helpers\Url;

/**
 * @property integer $id
 * @property string $alias
 * @property string $date
 * @property string $title
 * @property string $hidetitle
 * @property string $pagetitle
 * @property string $description
 * @property string $robots
 * @property string $styles
 * @property string $text
 * @property string $text_purified
 * @property string $layout
 * @property string $subpages_layout
 * @property int $parent_id
 * @property string $system
 *
 * @property Page[] $children
 * @property Page|null $parent
 *
 * @mixin CategoryTreeBehavior
 */
class Page extends ActiveRecord
{
    public const INDEX_FOLLOW = 'index, follow';
    public const INDEX_NOFOLLOW = 'index, nofollow';
    public const NOINDEX_FOLLOW = 'noindex, follow';
    public const NOINDEX_NOFOLLOW = 'noindex, nofollow';

    public const LAYOUTS = [
        'default' => 'По умолчанию',
        'fullscreen' => 'Во всю ширину',
        'leftcolumn' => 'Колонка с левым сайдбаром',
        'rightcolumn' => 'Колонка с правым сайдбаром',
        'blank' => 'Полноэкранный без контейнера',
    ];

    public const SUBPAGES_LAYOUTS = [
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
        return new PageQuery(static::class);
    }

    public function rules(): array
    {
        return [
            [['alias', 'title'], 'required'],
            ['alias', 'match', 'pattern' => '#^\w[a-zA-Z0-9_-]+$#', 'message' => 'Допустимы только латинские символы, цифры и знак подчёркивания'],
            [['alias', 'title', 'pagetitle', 'robots', 'layout', 'subpages_layout'], 'string', 'max' => 255],
            [['hidetitle', 'parent_id'], 'integer'],
            [['date', 'styles', 'text', 'description', 'system'], 'safe'],
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
            'layout' => 'Шаблон страницы',
            'layout_list_id' => 'Шаблон списка новостей',
            'layout_item_id' => 'Шаблон страницы новости',
            'layout_item_content_id' => 'Шаблон контента новости',
            'subpages_layout' => 'Вид списка дочерних страниц',
            'alias' => 'URL транслитом',
            'date' => 'Дата создания',
            'title' => 'Заголовок',
            'hidetitle' => 'Скрыть заголовок',
            'pagetitle' => 'Заголовок окна (title)',
            'description' => 'Описание (description)',
            'robots' => 'Индексация (robots)',
            'system' => 'Системная',
            'styles' => 'CSS стили',
            'text' => 'Текст',
            'parent_id' => 'Родительская страница',
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
            'PurifyText' => [
                'class' => PurifyTextBehavior::class,
                'sourceAttribute' => 'text',
                'destinationAttribute' => 'text_purified',
                'purifierOptions' => [
                    'Attr.AllowedRel' => ['nofollow'],
                    'HTML.SafeIframe' => true,
                    'URI.SafeIframeRegexp' => '%^(https?:)?//(www\.youtube(?:-nocookie)?\.com/embed/|player\.vimeo\.com/video/)%',
                ],
                'processOnBeforeSave' => true,
            ],
        ];
    }

    public function afterFind(): void
    {
        if ($this->date === '0000-00-00') {
            $this->date = date('Y-m-d');
        }
        parent::afterFind();
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

    private ?string $cachedUrl = null;

    public function getUrl(): string
    {
        if ($this->cachedUrl === null) {
            $this->cachedUrl = Url::to(['/page/page/show', 'path' => $this->getPath()]);
        }
        return $this->cachedUrl;
    }

    public function isIndexed(): bool
    {
        return in_array($this->robots, [self::INDEX_FOLLOW, self::INDEX_NOFOLLOW], true);
    }

    public function beforeSave($insert): bool
    {
        if (parent::beforeSave($insert)) {
            $this->fillDefaultValues();
            return true;
        }
        return false;
    }

    private function fillDefaultValues(): void
    {
        if (!$this->alias) {
            $this->alias = Slugger::slug($this->title);
        }
        if (!$this->pagetitle) {
            $this->pagetitle = strip_tags($this->title);
        }
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
