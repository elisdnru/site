<?php

namespace app\modules\page\models;

use app\components\ActiveRecord;
use app\components\TreeActiveDataProvider;
use app\components\helpers\TextHelper;
use CDbCriteria;
use Yii;

/**
 * @property integer $id
 * @property string $alias
 * @property string $date
 * @property string $title
 * @property string $hidetitle
 * @property string $pagetitle
 * @property string $description
 * @property string $keywords
 * @property string $robots
 * @property string $styles
 * @property string $text
 * @property string $text_purified
 * @property string $image
 * @property string $image_alt
 * @property string $layout
 * @property string $subpages_layout
 * @property string $parent_id
 * @property string $system
 *
 * @property string $url
 *
 * DTreeCategoryBehavior
 * @method mixed getArray()
 * @method Page findByAlias($alias)
 * @method Page findByPath($path)
 * @method boolean isChildOf($parent)
 * @method mixed getChildsArray($parent = 0)
 * @method mixed getAssocList($parent = 0)
 * @method mixed getAliasList($parent = 0)
 * @method mixed getTabList($parent = 0)
 * @method mixed getMenuList($sub = 0, $parent = 0)
 * @method string getPath($separator = '/')
 * @method mixed getBreadcrumbs($lastLink = false)
 */
class Page extends ActiveRecord
{
    const IMAGE_WIDTH = 250;
    const IMAGE_PATH = 'upload/images/pages';

    const INDEX_FOLLOW = 'index, follow';
    const INDEX_NOFOLLOW = 'index, nofollow';
    const NOINDEX_FOLLOW = 'noindex, follow';
    const NOINDEX_NOFOLLOW = 'noindex, nofollow';

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

    public $del_image = false;
    public $indent = 0;

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'pages';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return [
            ['alias, title', 'required'],
            ['alias', 'match', 'pattern' => '#^\w[a-zA-Z0-9_-]+$#', 'message' => 'Допустимы только латинские символы, цифры и знак подчёркивания'],
            ['alias, title, image_alt, pagetitle, keywords, robots, layout, subpages_layout', 'length', 'max' => 255],
            ['hidetitle, parent_id', 'numerical', 'integerOnly' => true],
            ['date, styles, text, description, del_image', 'safe'],
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            ['id, layout, subpages_layout, alias, date, title, pagetitle, description, keywords, text', 'safe', 'on' => 'search'],
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
            'parent' => [self::BELONGS_TO, self::class, 'parent_id'],
            'child_pages' => [self::HAS_MANY, self::class, 'parent_id',
                'order' => 'child_pages.id ASC'
            ],
            'child_pages_count' => [self::STAT, self::class, 'parent_id'],
        ];
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
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
            'keywords' => 'Ключевые слова (keywords)',
            'robots' => 'Индексация (robots)',
            'styles' => 'CSS стили',
            'text' => 'Текст',
            'image' => 'Изображение',
            'del_image' => 'Удалить изображение',
            'image_alt' => 'Описание для изображения',
            'file' => 'Приложенные файлы',
            'parent_id' => 'Родительская страница',
        ];
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @param int $pageSize
     * @return TreeActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search($pageSize = 10)
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
        $criteria->compare('t.keywords', $this->keywords, true);
        $criteria->compare('t.text', $this->text, true);
        $criteria->compare('t.image', $this->image, true);
        $criteria->compare('t.image_alt', $this->image_alt, true);
        $criteria->compare('t.parent_id', $this->parent_id);
        $criteria->compare('t.robots', $this->robots);

        return new TreeActiveDataProvider($this, [
            'criteria' => $criteria,
            'childRelation' => 'child_pages',
            'sort' => [
                'defaultOrder' => 't.alias ASC',
            ],
            'pagination' => [
                'pageSize' => $pageSize,
                'pageVar' => 'page',
            ],
        ]);
    }

    public function behaviors()
    {
        return [
            'CategoryBehavior' => [
                'class' => \app\components\category\behaviors\CategoryTreeBehavior::class,
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
                'class' => \app\components\arbehaviors\PurifyTextBehavior::class,
                'sourceAttribute' => 'text',
                'destinationAttribute' => 'text_purified',
                'purifierOptions' => [
                    'Attr.AllowedRel' => ['nofollow'],
                    'HTML.SafeObject' => true,
                    'Output.FlashCompat' => true,
                    'HTML.SafeIframe' => true,
                    'URI.SafeIframeRegexp' => '%^(https?:)?//(www\.youtube(?:-nocookie)?\.com/embed/|player\.vimeo\.com/video/)%',
                ],
                'processOnBeforeSave' => true,
            ],
            'ImageUpload' => [
                'class' => \app\components\uploader\FileUploadBehavior::class,
                'fileAttribute' => 'image',
                'deleteAttribute' => 'del_image',
                'enableWatermark' => true,
                'filePath' => self::IMAGE_PATH,
                'defaultThumbWidth' => self::IMAGE_WIDTH,
            ],
        ];
    }

    public function getRobotsList()
    {
        return [
            self::INDEX_FOLLOW => self::INDEX_FOLLOW,
            self::INDEX_NOFOLLOW => self::INDEX_NOFOLLOW,
            self::NOINDEX_FOLLOW => self::NOINDEX_FOLLOW,
            self::NOINDEX_NOFOLLOW => self::NOINDEX_NOFOLLOW,
        ];
    }

    private $_url;

    public function getUrl()
    {
        if ($this->_url === null) {
            $this->_url = Yii::app()->createUrl('page/page/show', ['path' => $this->path]);
        }
        return $this->_url;
    }

    protected function beforeSave()
    {
        if (parent::beforeSave()) {
            $this->fillDefaultValues();
            return true;
        }
        return false;
    }

    private function fillDefaultValues()
    {
        if (!$this->alias) {
            $this->alias = TextHelper::strToChpu($this->title);
        }
        if (!$this->pagetitle) {
            $this->pagetitle = strip_tags($this->title);
        }
        if (!$this->image_alt) {
            $this->image_alt = $this->title;
        }
    }

    protected function beforeDelete()
    {
        if (parent::beforeDelete()) {
            $this->delChildPages();
            return true;
        }
        return false;
    }

    private function delChildPages()
    {
        foreach ($this->child_pages as $child) {
            $child->delete();
        }
    }
}
