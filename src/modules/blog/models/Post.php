<?php

namespace app\modules\blog\models;

use app\components\ActiveRecord;
use app\components\module\UrlRulesHelper;
use app\modules\comment\components\CommentDepends;
use app\components\helpers\TextHelper;
use CActiveDataProvider;
use CDbCriteria;
use CHtml;
use Yii;

/**
 * @property integer $id
 * @property string $date
 * @property string $update_date
 * @property string $category_id
 * @property integer $author_id
 * @property string $alias
 * @property string $title
 * @property string $pagetitle
 * @property string $description
 * @property string $keywords
 * @property string $short
 * @property string $short_purified
 * @property string $text
 * @property string $text_purified
 * @property string $image
 * @property string $image_width
 * @property string $image_height
 * @property string $image_alt
 * @property integer $image_show
 * @property integer $group_id
 * @property integer $public
 *
 * @property string $url
 * @property string $imageUrl
 * @property string $imageThumdUrl
 * @property integer $comments_count
 * @property integer $comments_new_count
 *
 * @method Post published()
 */
class Post extends ActiveRecord implements CommentDepends
{
    const IMAGE_WIDTH = 250;
    const IMAGE_PATH = 'upload/images/blogs';

    public $del_image = false;

    public $newgroup = '';

    protected $tags_string;

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'blog_posts';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return [
            ['category_id, alias, title', 'required'],
            ['author_id', \app\components\ExistOrEmpty::class, 'className' => \app\modules\user\models\User::class, 'attributeName' => 'id'],
            ['category_id', 'exist', 'className' => \app\modules\blog\models\Category::class, 'attributeName' => 'id'],
            ['group_id', \app\components\ExistOrEmpty::class, 'className' => \app\modules\blog\models\Group::class, 'attributeName' => 'id'],
            ['public, image_show', 'numerical', 'integerOnly' => true],
            ['date', 'date', 'format' => 'yyyy-MM-dd hh:mm:ss'],
            ['short, text, description, del_image', 'safe'],
            ['title, alias, newgroup, image_alt, pagetitle, keywords', 'length', 'max' => '255'],
            ['tagsString', 'length', 'max' => '255'],
            ['alias', 'match', 'pattern' => '#^\w[a-zA-Z0-9_-]+$#', 'message' => 'Допустимы только латинские символы, цифры и знак подчёркивания'],
            ['alias', 'unique', 'caseSensitive' => false, 'message' => 'Такой {attribute} уже используется'],
            ['author_id', 'default', 'value' => Yii::app()->user->id],
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            ['id, date, category_id, author_id, title, pagetitle, description, keywords, image_alt, text, public', 'safe', 'on' => 'search'],
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
            'category' => [self::BELONGS_TO, \app\modules\blog\models\Category::class, 'category_id'],
            'author' => [self::BELONGS_TO, \app\modules\user\models\User::class, 'author_id'],
            'group' => [self::BELONGS_TO, \app\modules\blog\models\Group::class, 'group_id'],
            'posttags' => [self::HAS_MANY, \app\modules\blog\models\PostTag::class, 'post_id'],
            'tags' => [self::MANY_MANY, \app\modules\blog\models\Tag::class, 'blog_post_tags(post_id, tag_id)', 'order' => 'tags.title'],
        ];
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'date' => 'Дата создания',
            'update_date' => 'Дата обновления',
            'category_id' => 'Раздел',
            'author_id' => 'Автор',
            'title' => 'Заголовок',
            'alias' => 'URL транслитом',
            'pagetitle' => 'Заголовок страницы (title)',
            'description' => 'Описание (description)',
            'keywords' => 'Ключевые слова (keywords)',
            'short' => 'Превью',
            'text' => 'Текст',
            'image' => 'Картинка для статьи',
            'del_image' => 'Удалить изображение',
            'image_alt' => 'Описание изображения (по умолчанию как заголовок)',
            'image_show' => 'Отображать при открытии новости',
            'group_id' => 'Выберите тематическую группу',
            'newgroup' => '...или введите имя новой',
            'public' => 'Опубликовано',
        ];
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @param int $pageSize
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search($pageSize = 10)
    {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('t.date', $this->date, true);
        $criteria->compare('t.update_date', $this->update_date, true);
        $criteria->compare('t.category_id', $this->category_id);
        $criteria->compare('t.author_id', $this->author_id);
        $criteria->compare('t.alias', $this->alias, true);
        $criteria->compare('t.title', $this->title, true);
        $criteria->compare('t.public', $this->public);
        $criteria->compare('t.group_id', $this->group_id);

        $criteria->with = ['category', 'author', 'group'];

        return new CActiveDataProvider($this, [
            'criteria' => $criteria,
            'sort' => [
                'defaultOrder' => 't.date DESC',
                'attributes' => [
                    'date',
                    'update_date',
                    'title',
                    'category_id' => [
                        'asc' => 'category.title ASC',
                        'desc' => 'category.title DESC',
                    ],
                    'author_id' => [
                        'asc' => 'author.username ASC',
                        'desc' => 'author.username DESC',
                    ],
                    'group_id' => [
                        'asc' => 'group.title ASC',
                        'desc' => 'group.title DESC',
                    ],
                    'public',
                ]
            ],
            'pagination' => [
                'pageSize' => $pageSize,
                'pageVar' => 'page',
            ],
        ]);
    }

    public function scopes()
    {
        return [
            'published' => [
                'condition' => 't.public=1 AND t.date <= NOW()',
            ],
        ];
    }

    public function behaviors()
    {
        return [
            'CTimestampBehavior' => [
                'class' => 'zii.behaviors.CTimestampBehavior',
                'setUpdateOnCreate' => true,
                'createAttribute' => 'date',
                'updateAttribute' => 'update_date',
            ],
            'PurifyShort' => [
                'class' => \app\components\arbehaviors\PurifyTextBehavior::class,
                'sourceAttribute' => 'short',
                'destinationAttribute' => 'short_purified',
                'purifierOptions' => [
                    'Attr.AllowedRel' => ['nofollow'],
                    'HTML.Nofollow' => true,
                ],
                'processOnBeforeSave' => true,
            ],
            'PurifyText' => [
                'class' => \app\components\arbehaviors\PurifyTextBehavior::class,
                'sourceAttribute' => 'text',
                'destinationAttribute' => 'text_purified',
                'enableMarkdown' => true,
                'enablePurifier' => false,
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
                'imageWidthAttribute' => 'image_width',
                'imageHeightAttribute' => 'image_height',
            ],
            'PingBehavior' => [
                'class' => \app\components\arbehaviors\PingBehavior::class,
                'urlAttribute' => 'url',
            ],
        ];
    }

    protected function beforeDelete()
    {
        if (parent::beforeDelete()) {
            foreach ($this->posttags as $posttag) {
                $posttag->delete();
            }
            return true;
        }
        return false;
    }

    protected function beforeSave()
    {
        if (parent::beforeSave()) {
            $this->fillDefaultValues();
            $this->processThematicGroup();
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
        if (!$this->description) {
            $this->description = strip_tags($this->short);
        }
        if (!$this->image_alt) {
            $this->image_alt = $this->title;
        }
    }

    private function processThematicGroup()
    {
        if ($this->newgroup) {
            $group = new Group();
            $group->title = $this->newgroup;
            if ($group->save()) {
                $this->group_id = $group->id;
                $this->newgroup = '';
            }
        }
    }

    protected function afterSave()
    {
        $this->updateTags();
        parent::afterSave();
    }

    public function getAssocList($only_public = false)
    {
        if ($only_public) {
            $items = self::model()->published()->findAll(['order' => 'date DESC']);
        } else {
            $items = self::model()->findAll(['order' => 'date DESC']);
        }

        $result = [];
        foreach ($items as $item) {
            $result[$item['id']] = $item['title'];
        }

        return $result;
    }

    public function findByAlias($alias)
    {
        return $this->findByAttributes(['alias' => $alias]);
    }

    public function getTagsString()
    {
        if ($this->tags_string === null) {
            $list = CHtml::listData($this->cache(0)->tags, 'id', 'title');
            $this->tags_string = implode(', ', $list);
        }

        return $this->tags_string;
    }

    public function setTagsString($value)
    {
        $this->tags_string = $value;
    }

    private function updateTags()
    {
        $newtags = array_unique(preg_split('/\s*,\s*/', $this->tagsString));

        foreach ($this->posttags as $posttag) {
            $posttag->delete();
        }

        foreach ($newtags as $tagname) {
            $tag = Tag::model()->findOrCreateByTitle($tagname);

            $posttag = new PostTag;
            $posttag->post_id = $this->id;
            $posttag->tag_id = $tag->id;
            $posttag->save();
        }
    }

    private $_url;

    public function getUrl()
    {
        if ($this->_url === null) {
            UrlRulesHelper::import('blog');
            $this->_url = Yii::app()->createUrl('/blog/post/show', ['id' => $this->getPrimaryKey(), 'alias' => $this->alias]);
        }
        return $this->_url;
    }

    public function updateCommentsState($comment)
    {
        $comments_count = Comment::model()->material($this->id)->count('public=1');
        $comments_new_count = Comment::model()->material($this->id)->count('public=1 AND moder=0');

        $this->updateByPk($this->id, ['comments_count' => $comments_count]);
        $this->updateByPk($this->id, ['comments_new_count' => $comments_new_count]);
    }
}