<?php

namespace app\modules\page\models;

use app\components\purifier\PurifyTextBehaviorV1;
use app\components\category\behaviors\CategoryTreeBehavior;
use app\components\category\TreeActiveDataProvider;
use app\components\Transliterator;
use CActiveRecord;
use CDbCriteria;
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
 * @property string $parent_id
 * @property string $system
 *
 * @property Page[] $children
 * @property Page $parent
 *
 * @mixin CategoryTreeBehavior
 */
class Page extends CActiveRecord
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

    public $indent = 0;

    /**
     * @param string|null $className
     * @return CActiveRecord|static
     */
    public static function model($className = null): self
    {
        return parent::model($className ?: static::class);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName(): string
    {
        return 'pages';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules(): array
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return [
            ['alias, title', 'required'],
            ['alias', 'match', 'pattern' => '#^\w[a-zA-Z0-9_-]+$#', 'message' => 'Допустимы только латинские символы, цифры и знак подчёркивания'],
            ['alias, title, pagetitle, robots, layout, subpages_layout', 'length', 'max' => 255],
            ['hidetitle, parent_id', 'numerical', 'integerOnly' => true],
            ['date, styles, text, description, system', 'safe'],
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            ['id, layout, subpages_layout, alias, date, title, pagetitle, description, text', 'safe', 'on' => 'search'],
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
            'parent' => [self::BELONGS_TO, self::class, 'parent_id'],
            'children' => [self::HAS_MANY, self::class, 'parent_id',
                'order' => 'children.id ASC'
            ],
        ];
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
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

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @param int $pageSize
     * @return TreeActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search($pageSize = 10): TreeActiveDataProvider
    {
        $criteria = new CDbCriteria;

        $criteria->compare('t.id', $this->id);
        $criteria->compare('t.layout', $this->layout);
        $criteria->compare('t.subpages_layout', $this->subpages_layout);
        $criteria->compare('t.alias', $this->alias, true);
        $criteria->compare('t.date', $this->date, true);
        $criteria->compare('t.title', $this->title, true);
        $criteria->compare('t.hidetitle', $this->hidetitle, true);
        $criteria->compare('t.pagetitle', $this->pagetitle, true);
        $criteria->compare('t.description', $this->description, true);
        $criteria->compare('t.text', $this->text, true);
        $criteria->compare('t.parent_id', $this->parent_id);
        $criteria->compare('t.robots', $this->robots);

        return new TreeActiveDataProvider($this, [
            'criteria' => $criteria,
            'childRelation' => 'children',
            'sort' => [
                'defaultOrder' => 't.alias ASC',
            ],
            'pagination' => [
                'pageSize' => $pageSize,
                'pageVar' => 'page',
            ],
        ]);
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
                'defaultCriteria' => [
                    'order' => 't.parent_id ASC, t.title ASC',
                ],
            ],
            'PurifyText' => [
                'class' => PurifyTextBehaviorV1::class,
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

    public function getRobotsList(): array
    {
        return [
            self::INDEX_FOLLOW => self::INDEX_FOLLOW,
            self::INDEX_NOFOLLOW => self::INDEX_NOFOLLOW,
            self::NOINDEX_FOLLOW => self::NOINDEX_FOLLOW,
            self::NOINDEX_NOFOLLOW => self::NOINDEX_NOFOLLOW,
        ];
    }

    private $cachedUrl;

    public function getUrl(): string
    {
        if ($this->cachedUrl === null) {
            $this->cachedUrl = Url::to(['/page/page/show', 'path' => $this->getPath()]);
        }
        return $this->cachedUrl;
    }

    protected function beforeSave(): bool
    {
        if (parent::beforeSave()) {
            $this->fillDefaultValues();
            return true;
        }
        return false;
    }

    private function fillDefaultValues(): void
    {
        if (!$this->alias) {
            $this->alias = Transliterator::slug($this->title);
        }
        if (!$this->pagetitle) {
            $this->pagetitle = strip_tags($this->title);
        }
    }

    protected function beforeDelete(): bool
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
