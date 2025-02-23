<?php

declare(strict_types=1);

namespace app\modules\blog\models;

use app\components\ForceActiveRecordErrors;
use app\components\uploader\FileUploadBehavior;
use app\modules\comment\models\Comment;
use app\modules\comment\models\Material;
use app\modules\user\models\User;
use BadMethodCallException;
use Override;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\helpers\Url;
use yii\web\UploadedFile;

/**
 * @property int $id
 * @property string $date
 * @property string $update_date
 * @property int $category_id
 * @property int $author_id
 * @property string $slug
 * @property string $title
 * @property string $meta_title
 * @property string $meta_description
 * @property string|null $styles
 * @property string $short
 * @property string $text
 * @property string|UploadedFile|null $image
 * @property string $image_alt
 * @property bool $image_show
 * @property int|null $group_id
 * @property bool $public
 * @property bool $promoted
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
    use ForceActiveRecordErrors;

    public ?bool $del_image = null;

    #[Override]
    public static function tableName(): string
    {
        return 'blog_posts';
    }

    #[Override]
    public static function find(): PostQuery
    {
        return new PostQuery(self::class);
    }

    /**
     * @param Tag[] $tags
     */
    public function assignTags(array $tags): void
    {
        if (empty($this->id)) {
            throw new BadMethodCallException('Unable to assign tags.');
        }

        foreach ($this->postTags as $postTag) {
            $postTag->delete();
        }

        foreach ($tags as $tag) {
            $postTag = new PostTag();
            $postTag->post_id = $this->id;
            $postTag->tag_id = $tag->id;
            $postTag->save();
        }
    }

    /**
     * @psalm-api
     */
    public function getPostTags(): ActiveQuery
    {
        return $this->hasMany(PostTag::class, ['post_id' => 'id']);
    }

    /**
     * @psalm-api
     */
    public function getTags(): ActiveQuery
    {
        return $this->hasMany(Tag::class, ['id' => 'tag_id'])->via('postTags');
    }

    /**
     * @psalm-api
     */
    public function getGroup(): ActiveQuery
    {
        return $this->hasOne(Group::class, ['id' => 'group_id']);
    }

    /**
     * @psalm-api
     */
    public function getCategory(): ActiveQuery
    {
        return $this->hasOne(Category::class, ['id' => 'category_id']);
    }

    /**
     * @psalm-api
     */
    public function getAuthor(): ActiveQuery
    {
        return $this->hasOne(User::class, ['id' => 'author_id']);
    }

    public function getCommentsCount(): int
    {
        return (int)Comment::find()->type(self::class)->material($this->id)->published()->count();
    }

    public function getCommentsNewCount(): int
    {
        return (int)Comment::find()->type(self::class)->material($this->id)->published()->unread()->count();
    }

    #[Override]
    public function behaviors(): array
    {
        return [
            'Timestamp' => [
                'class' => TimestampBehavior::class,
                'createdAtAttribute' => 'date',
                'updatedAtAttribute' => 'update_date',
                'value' => static fn () => date('Y-m-d H:i:s'),
            ],
            'ImageUpload' => [
                'class' => FileUploadBehavior::class,
                'fileAttribute' => 'image',
                'storageAttribute' => 'image',
                'deleteAttribute' => 'del_image',
                'filePath' => 'upload/images/blogs',
            ],
        ];
    }

    #[Override]
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

    #[Override]
    public function getCommentTitle(): string
    {
        return $this->title;
    }

    #[Override]
    public function getCommentUrl(): string
    {
        return Url::to(['/blog/post/show', 'id' => $this->id, 'slug' => $this->slug]);
    }
}
