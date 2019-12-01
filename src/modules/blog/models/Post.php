<?php

namespace app\modules\blog\models;

use app\components\purifier\PurifyTextBehaviorV1;
use app\components\uploader\FileUploadBehaviorV1;
use app\components\ExistOrEmptyValidatorV1;
use app\components\Transliterator;
use app\modules\comment\models\Material;
use app\modules\user\models\User;
use CActiveDataProvider;
use CActiveRecord;
use CDbCriteria;
use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

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
 * @property string $styles
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
 * @property integer $commentsCount
 * @property integer $commentsNewCount
 * @property User $author
 * @property PostTag $posttags
 * @property Category $category
 * @property Tag[] $tags
 *
 * @mixin FileUploadBehaviorV1
 * @method Post published()
 */
class Post extends CActiveRecord implements Material
{
    private const IMAGE_WIDTH = 250;
    private const IMAGE_PATH = 'upload/images/blogs';

    public $del_image = false;

    public $newgroup = '';

    protected $tags_string;

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
        return 'blog_posts';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules(): array
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return [
            ['category_id, alias, title', 'required'],
            ['author_id', \app\components\ExistOrEmptyValidator::class, 'className' => User::class, 'attributeName' => 'id'],
            ['category_id', 'exist', 'className' => Category::class, 'attributeName' => 'id'],
            ['group_id', ExistOrEmptyValidatorV1::class, 'className' => Group::class, 'attributeName' => 'id'],
            ['public, image_show', 'numerical', 'integerOnly' => true],
            ['date', 'date', 'format' => 'yyyy-MM-dd hh:mm:ss'],
            ['styles, short, text, description, del_image', 'safe'],
            ['title, alias, newgroup, image_alt, pagetitle', 'length', 'max' => '255'],
            ['tagsString', 'length', 'max' => '255'],
            ['alias', 'match', 'pattern' => '#^\w[a-zA-Z0-9_-]+$#', 'message' => 'Допустимы только латинские символы, цифры и знак подчёркивания'],
            ['alias', 'unique', 'caseSensitive' => false, 'message' => 'Такой {attribute} уже используется'],
            ['author_id', 'default', 'value' => Yii::$app->user->id],
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            ['id, date, category_id, author_id, title, pagetitle, description, image_alt, text, public', 'safe', 'on' => 'search'],
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
            'category' => [self::BELONGS_TO, Category::class, 'category_id'],
            'group' => [self::BELONGS_TO, Group::class, 'group_id'],
            'posttags' => [self::HAS_MANY, PostTag::class, 'post_id'],
            'tags' => [self::MANY_MANY, Tag::class, 'blog_post_tags(post_id, tag_id)', 'order' => 'tags.title'],
        ];
    }

    public function getAuthor(): ?User
    {
        return User::findOne($this->author_id);
    }

    public function getCommentsCount(): int
    {
        return Comment::find()->material($this->id)->published()->count();
    }

    public function getCommentsNewCount(): int
    {
        return Comment::find()->material($this->id)->published()->unread()->count();
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels(): array
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
            'styles' => 'CSS стили',
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
    public function search($pageSize = 10): CActiveDataProvider
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

        $criteria->with = ['category', 'group'];

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
                'validateCurrentPage' => false,
            ],
        ]);
    }

    public function scopes(): array
    {
        return [
            'published' => [
                'condition' => 't.public=1 AND t.date <= NOW()',
            ],
        ];
    }

    public function behaviors(): array
    {
        return [
            'CTimestampBehavior' => [
                'class' => 'zii.behaviors.CTimestampBehavior',
                'setUpdateOnCreate' => true,
                'createAttribute' => 'date',
                'updateAttribute' => 'update_date',
            ],
            'PurifyShort' => [
                'class' => PurifyTextBehaviorV1::class,
                'sourceAttribute' => 'short',
                'destinationAttribute' => 'short_purified',
                'purifierOptions' => [
                    'Attr.AllowedRel' => ['nofollow'],
                    'HTML.Nofollow' => true,
                ],
                'processOnBeforeSave' => true,
            ],
            'PurifyText' => [
                'class' => PurifyTextBehaviorV1::class,
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
                'class' => FileUploadBehaviorV1::class,
                'fileAttribute' => 'image',
                'deleteAttribute' => 'del_image',
                'enableWatermark' => true,
                'filePath' => self::IMAGE_PATH,
                'defaultThumbWidth' => self::IMAGE_WIDTH,
                'imageWidthAttribute' => 'image_width',
                'imageHeightAttribute' => 'image_height',
            ],
        ];
    }

    protected function beforeDelete(): bool
    {
        if (parent::beforeDelete()) {
            foreach ($this->posttags as $posttag) {
                $posttag->delete();
            }
            return true;
        }
        return false;
    }

    protected function beforeSave(): bool
    {
        if (parent::beforeSave()) {
            $this->fillDefaultValues();
            $this->processThematicGroup();
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
        if (!$this->description) {
            $this->description = strip_tags($this->short);
        }
        if (!$this->image_alt) {
            $this->image_alt = $this->title;
        }
    }

    private function processThematicGroup(): void
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

    protected function afterSave(): void
    {
        $this->updateTags();
        parent::afterSave();
    }

    public function getAssocList(bool $only_public = false): array
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

    public function findByAlias(string $alias): ?Post
    {
        return $this->findByAttributes(['alias' => $alias]);
    }

    public function getTagsString(): string
    {
        if ($this->tags_string === null) {
            /** @var self $cached */
            $cached = $this->cache(0);
            $list = ArrayHelper::map($cached->tags, 'id', 'title');
            $this->tags_string = implode(', ', $list);
        }

        return $this->tags_string;
    }

    public function setTagsString(?string $value): void
    {
        $this->tags_string = $value;
    }

    private function updateTags(): void
    {
        $newtags = array_unique(preg_split('/\s*,\s*/', $this->getTagsString()));

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

    private $cachedUrl;

    public function getUrl(): string
    {
        if ($this->cachedUrl === null) {
            $this->cachedUrl = Url::to(['/blog/post/show', 'id' => $this->getPrimaryKey(), 'alias' => $this->alias]);
        }
        return $this->cachedUrl;
    }
}
