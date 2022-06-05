<?php

declare(strict_types=1);

namespace app\modules\blog\models;

use app\components\purifier\PurifyTextBehavior;
use app\components\SlugValidator;
use app\components\uploader\FileUploadBehavior;
use app\modules\comment\models\Material;
use app\modules\user\models\User;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

/**
 * @property int $id
 * @property string $date
 * @property string $update_date
 * @property string $category_id
 * @property int $author_id
 * @property string $slug
 * @property string $title
 * @property string $meta_title
 * @property string $meta_description
 * @property string $styles
 * @property string $short
 * @property string $short_purified
 * @property string $text
 * @property string $text_purified
 * @property string $image
 * @property string $image_alt
 * @property int $image_show
 * @property int $group_id
 * @property int $public
 * @property int $promoted
 *
 * @property User $author
 * @property Group|null $group
 * @property PostTag[] $postTags
 * @property Category $category
 * @property Tag[] $tags
 *
 * @mixin FileUploadBehavior
 */
final class Post extends ActiveRecord implements Material
{
    public string $delImage = '';

    public string $newGroup = '';

    private ?string $tags_string = null;

    private ?string $cachedUrl = null;

    public static function tableName(): string
    {
        return 'blog_posts';
    }

    public static function find(): PostQuery
    {
        return new PostQuery(self::class);
    }

    public function rules(): array
    {
        return [
            [['category_id', 'slug', 'title'], 'required'],
            ['author_id', 'exist', 'targetClass' => User::class, 'targetAttribute' => 'id'],
            ['category_id', 'exist', 'targetClass' => Category::class, 'targetAttribute' => 'id'],
            ['group_id', 'exist', 'targetClass' => Group::class, 'targetAttribute' => 'id'],
            [['public', 'image_show', 'promoted'], 'integer'],
            ['date', 'date', 'format' => 'php:Y-m-d H:i:s'],
            [['styles', 'short', 'text', 'meta_description', 'delImage'], 'safe'],
            [['title', 'slug', 'newGroup', 'image_alt', 'meta_title'], 'string', 'max' => '255'],
            ['tagsString', 'string'],
            ['slug', SlugValidator::class],
            ['slug', 'unique', 'message' => 'Такой {attribute} уже используется'],
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
            'slug' => 'URL транслитом',
            'meta_title' => 'Заголовок страницы',
            'meta_description' => 'Описание',
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
            'promoted' => 'Продвигать',
        ];
    }

    public function behaviors(): array
    {
        return [
            'Timestamp' => [
                'class' => TimestampBehavior::class,
                'createdAtAttribute' => 'date',
                'updatedAtAttribute' => 'update_date',
                'value' => static fn () => date('Y-m-d H:i:s'),
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
                ],
                'processOnBeforeSave' => true,
            ],
            'ImageUpload' => [
                'class' => FileUploadBehavior::class,
                'fileAttribute' => 'image',
                'storageAttribute' => 'image',
                'deleteAttribute' => 'delImage',
                'filePath' => 'upload/images/blogs',
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
            $this->processThematicGroup();
            return true;
        }
        return false;
    }

    public function afterSave($insert, $changedAttributes): void
    {
        $this->updateTags();
        parent::afterSave($insert, $changedAttributes);
    }

    public function getTagsString(): string
    {
        if ($this->tags_string === null) {
            /** @var string[] $list */
            $list = ArrayHelper::map($this->tags, 'id', 'title');
            $this->tags_string = implode(', ', $list);
        }

        return $this->tags_string;
    }

    public function setTagsString(?string $value): void
    {
        $this->tags_string = $value;
    }

    public function getUrl(): string
    {
        if ($this->cachedUrl === null) {
            $this->cachedUrl = Url::to(['/blog/post/show', 'id' => $this->getPrimaryKey(), 'slug' => $this->slug]);
        }
        return $this->cachedUrl;
    }

    public function getCommentTitle(): string
    {
        return $this->title;
    }

    public function getCommentUrl(): string
    {
        return $this->getUrl();
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

    private function updateTags(): void
    {
        $newtags = array_filter(array_unique(preg_split('/\s*,\s*/', $this->getTagsString())));

        foreach ($this->postTags as $postTag) {
            $postTag->delete();
        }

        foreach ($newtags as $tagname) {
            $tag = Tag::findOrCreateByTitle($tagname);

            $postTag = new PostTag();
            $postTag->post_id = $this->id;
            $postTag->tag_id = $tag->id;
            $postTag->save();
        }
    }
}
