<?php

namespace app\modules\blog\models;

use app\components\purifier\PurifyTextBehavior;
use app\components\Slugger;
use app\components\uploader\FileUploadBehavior;
use app\modules\blog\models\query\PostQuery;
use app\modules\comment\models\Material;
use app\modules\user\models\User;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\db\Expression;
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
 * @property string $meta_title
 * @property string $meta_description
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
 * @property User $author
 * @property Group|null $group
 * @property PostTag[] $postTags
 * @property Category $category
 * @property Tag[] $tags
 *
 * @mixin FileUploadBehavior
 */
class Post extends ActiveRecord implements Material
{
    private const IMAGE_WIDTH = 250;
    private const IMAGE_PATH = 'upload/images/blogs';

    public string $delImage = '';

    public string $newGroup = '';

    protected ?string $tags_string = null;

    public static function tableName(): string
    {
        return 'blog_posts';
    }

    public static function find(): PostQuery
    {
        return new PostQuery(static::class);
    }

    public function rules(): array
    {
        return [
            [['category_id', 'alias', 'title'], 'required'],
            ['author_id', 'exist', 'targetClass' => User::class, 'targetAttribute' => 'id'],
            ['category_id', 'exist', 'targetClass' => Category::class, 'targetAttribute' => 'id'],
            ['group_id', 'exist', 'targetClass' => Group::class, 'targetAttribute' => 'id'],
            [['public', 'image_show'], 'integer'],
            ['date', 'date', 'format' => 'php:Y-m-d H:i:s'],
            [['styles', 'short', 'text', 'meta_description', 'delImage'], 'safe'],
            [['title', 'alias', 'newGroup', 'image_alt', 'meta_title'], 'string', 'max' => '255'],
            ['tagsString', 'string', 'max' => '255'],
            ['alias', 'match', 'pattern' => '#^\w[a-zA-Z0-9_-]+$#', 'message' => 'Допустимы только латинские символы, цифры и знак подчёркивания'],
            ['alias', 'unique', 'message' => 'Такой {attribute} уже используется'],
            ['group_id', 'default', 'value' => 0],
        ];
    }

    public function getPostTags(): ActiveQuery
    {
        return $this->hasMany(PostTag::class, ['post_id' => 'id']);
    }

    public function getTags(): ActiveQuery
    {
        return $this->hasMany(Tag::class, ['id' => 'tag_id'])->via('postTags');
    }

    public function getGroup(): ActiveQuery
    {
        return $this->hasOne(Group::class, ['id' => 'group_id']);
    }

    public function getCategory(): ActiveQuery
    {
        return $this->hasOne(Category::class, ['id' => 'category_id']);
    }

    public function getAuthor(): ActiveQuery
    {
        return $this->hasOne(User::class, ['id' => 'author_id']);
    }

    public function getCommentsCount(): int
    {
        return (int)Comment::find()->material($this->id)->published()->count();
    }

    public function getCommentsNewCount(): int
    {
        return (int)Comment::find()->material($this->id)->published()->unread()->count();
    }

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
            'meta_title' => 'Заголовок страницы (title)',
            'meta_description' => 'Описание (meta_description)',
            'styles' => 'CSS стили',
            'short' => 'Превью',
            'text' => 'Текст',
            'image' => 'Картинка для статьи',
            'delImage' => 'Удалить изображение',
            'image_alt' => 'Описание изображения (по умолчанию как заголовок)',
            'image_show' => 'Отображать при открытии новости',
            'group_id' => 'Выберите тематическую группу',
            'newGroup' => '...или введите имя новой',
            'public' => 'Опубликовано',
        ];
    }

    public function behaviors(): array
    {
        return [
            'Timestamp' => [
                'class' => TimestampBehavior::class,
                'createdAtAttribute' => 'date',
                'updatedAtAttribute' => 'update_date',
                'value' => static function () {
                    return new Expression('NOW()');
                },
            ],
            'PurifyShort' => [
                'class' => PurifyTextBehavior::class,
                'sourceAttribute' => 'short',
                'destinationAttribute' => 'short_purified',
                'purifierOptions' => [
                    'Attr.AllowedRel' => ['nofollow'],
                    'HTML.Nofollow' => true,
                ],
                'processOnBeforeSave' => true,
            ],
            'PurifyText' => [
                'class' => PurifyTextBehavior::class,
                'sourceAttribute' => 'text',
                'destinationAttribute' => 'text_purified',
                'enableMarkdown' => true,
                'purifierOptions' => [
                    'Attr.AllowedRel' => ['nofollow'],
                    'HTML.SafeIframe' => true,
                    'URI.SafeIframeRegexp' => '%^(https?:)?//(www\.youtube(?:-nocookie)?\.com/embed/|player\.vimeo\.com/video/)%',
                ],
                'processOnBeforeSave' => true,
            ],
            'ImageUpload' => [
                'class' => FileUploadBehavior::class,
                'fileAttribute' => 'image',
                'deleteAttribute' => 'delImage',
                'filePath' => self::IMAGE_PATH,
                'defaultThumbWidth' => self::IMAGE_WIDTH,
                'imageWidthAttribute' => 'image_width',
                'imageHeightAttribute' => 'image_height',
            ],
        ];
    }

    public function beforeDelete(): bool
    {
        if (parent::beforeDelete()) {
            foreach ($this->postTags as $postTag) {
                $postTag->delete();
            }
            return true;
        }
        return false;
    }

    public function beforeSave($insert): bool
    {
        if (parent::beforeSave($insert)) {
            $this->fillDefaultValues();
            $this->processThematicGroup();
            return true;
        }
        return false;
    }

    private function fillDefaultValues(): void
    {
        if (!$this->alias) {
            $this->alias = Slugger::slug($this->title);
        }
        if (!$this->meta_title) {
            $this->meta_title = strip_tags($this->title);
        }
        if (!$this->meta_description) {
            $this->meta_description = strip_tags($this->short);
        }
        if (!$this->image_alt) {
            $this->image_alt = $this->title;
        }
    }

    private function processThematicGroup(): void
    {
        if ($this->newGroup) {
            $group = new Group();
            $group->title = $this->newGroup;
            if ($group->save()) {
                $this->group_id = $group->id;
                $this->newGroup = '';
            }
        }
    }

    public function afterSave($insert, $changedAttributes): void
    {
        $this->updateTags();
        parent::afterSave($insert, $changedAttributes);
    }

    public function getTagsString(): string
    {
        if ($this->tags_string === null) {
            $list = ArrayHelper::map($this->tags, 'id', 'title');
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
        $newtags = array_filter(array_unique(preg_split('/\s*,\s*/', $this->getTagsString())));

        foreach ($this->postTags as $postTag) {
            $postTag->delete();
        }

        foreach ($newtags as $tagname) {
            $tag = Tag::findOrCreateByTitle($tagname);

            $postTag = new PostTag;
            $postTag->post_id = $this->id;
            $postTag->tag_id = $tag->id;
            $postTag->save();
        }
    }

    private ?string $cachedUrl = null;

    public function getUrl(): string
    {
        if ($this->cachedUrl === null) {
            $this->cachedUrl = Url::to(['/blog/post/show', 'id' => $this->getPrimaryKey(), 'alias' => $this->alias]);
        }
        return $this->cachedUrl;
    }
}
