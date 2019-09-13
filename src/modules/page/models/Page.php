<?php

use app\components\module\DUrlRulesHelper;
use app\modules\main\components\DTreeActiveDataProvider;
use app\modules\main\components\helpers\DTextHelper;

/**
 * This is the model class for table "{{page}}".
 *
 * The followings are the available columns in table '{{page}}':
 * @property integer $id
 * @property string $alias
 * @property string $date
 * @property string $title
 * @property string $hidetitle
 * @property string $pagetitle
 * @property string $description
 * @property string $keywords
 * @property string $robots
 * @property string $text
 * @property string $text_purified
 * @property string $image
 * @property string $image_alt
 * @property string $layout_id
 * @property string $layout_subpages_id
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
class Page extends CActiveRecord
{
    const IMAGE_WIDTH = 250;
    const IMAGE_PATH = 'upload/images/pages';

    const INDEX_FOLLOW = 'index, follow';
    const INDEX_NOFOLLOW = 'index, nofollow';
    const NOINDEX_FOLLOW = 'noindex, follow';
    const NOINDEX_NOFOLLOW = 'noindex, nofollow';

    public $del_image = false;
    public $indent = 0;

    /**
     * Returns the static model of the specified AR class.
     * @param string $className
     * @return CActiveRecord|Page the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return '{{page}}';
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
            ['alias, title, image_alt, pagetitle, keywords, robots', 'length', 'max' => 255],
            ['hidetitle, parent_id, layout_id, layout_subpages_id', 'numerical', 'integerOnly' => true],
            ['date, text, description, del_image', 'safe'],
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            ['id, layout_id, layout_subpages_id, alias, date, title, pagetitle, description, keywords, text', 'safe', 'on' => 'search'],
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
            'layout' => [self::BELONGS_TO, \PageLayout::class, 'layout_id'],
            'layout_subpages' => [self::BELONGS_TO, \PageLayoutSubpages::class, 'layout_subpages_id'],
            'parent' => [self::BELONGS_TO, \Page::class, 'parent_id'],
            'child_pages' => [self::HAS_MANY, \Page::class, 'parent_id',
                'order' => 'child_pages.id ASC'
            ],
            'child_pages_count' => [self::STAT, \Page::class, 'parent_id'],
            'files' => [self::HAS_MANY, \PageFile::class, 'material_id',
                'order' => 'files.title DESC'
            ],
        ];
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'layout_id' => 'Шаблон страницы',
            'layout_list_id' => 'Шаблон списка новостей',
            'layout_item_id' => 'Шаблон страницы новости',
            'layout_item_content_id' => 'Шаблон контента новости',
            'layout_subpages_id' => 'Вид списка дочерних страниц',
            'alias' => 'URL транслитом',
            'date' => 'Дата создания',
            'title' => 'Заголовок',
            'hidetitle' => 'Скрыть заголовок',
            'pagetitle' => 'Заголовок окна (title)',
            'description' => 'Описание (description)',
            'keywords' => 'Ключевые слова (keywords)',
            'robots' => 'Индексация (robots)',
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
     * @return DTreeActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search($pageSize = 10)
    {
        $criteria = new CDbCriteria;

        $criteria->compare('t.id', $this->id);
        $criteria->compare('t.layout_id', $this->layout_id);
        $criteria->compare('t.layout_subpages_id', $this->layout_subpages_id);
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

        return new DTreeActiveDataProvider($this, [
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
                'class' => \app\modules\category\components\DCategoryTreeBehavior::class,
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
                'class' => \app\modules\main\components\arbehaviors\DPurifyTextBehavior::class,
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
                'class' => \app\modules\uploader\components\DFileUploadBehavior::class,
                'fileAttribute' => 'image',
                'deleteAttribute' => 'del_image',
                'enableWatermark' => true,
                'filePath' => self::IMAGE_PATH,
                'defaultThumbWidth' => self::IMAGE_WIDTH,
            ],
            'PingBehavior' => [
                'class' => \app\modules\main\components\arbehaviors\DPingBehavior::class,
                'urlAttribute' => 'url',
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

    public function allowedForUser(User $user)
    {
        if ($user->access_pages) {
            $allowed = $user->accessPagesArray;
            return in_array($this->primaryKey, $allowed) || $this->isChildOf($allowed);
        } else {
            return true;
        }
    }

    private $_url;

    public function getUrl()
    {
        if ($this->_url === null) {
            DUrlRulesHelper::import('page');
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
            $this->alias = DTextHelper::strToChpu($this->title);
        }
        if (!$this->pagetitle) {
            $this->pagetitle = strip_tags($this->title);
        }
        if (!$this->image_alt) {
            $this->image_alt = $this->title;
        }
    }

    protected function afterSave()
    {
        $this->loadFiles();
        parent::afterSave();
    }

    private function loadFiles()
    {
        if (!empty($_FILES['Page'])) {
            for ($i = 1; $i < PageFile::FILES_LIMIT + 1; $i++) {
                if ($_FILES['Page']['tmp_name']['file_' . $i]) {
                    $file = new PageFile();
                    $file->material_id = $this->id;
                    $file->file = CUploadedFile::getInstance($this, 'file_' . $i);
                    $file->save();
                }
                unset($_FILES['Page']['tmp_name']['file_' . $i]);
            }
        }
    }

    protected function beforeDelete()
    {
        if (parent::beforeDelete()) {
            $this->delFiles();
            $this->delChildPages();
            return true;
        }
        return false;
    }

    private function delFiles()
    {
        foreach ($this->files as $file) {
            $file->delete();
        }
    }

    private function delChildPages()
    {
        foreach ($this->child_pages as $child) {
            $child->delete();
        }
    }
}
