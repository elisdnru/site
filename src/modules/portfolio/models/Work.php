<?php

declare(strict_types=1);

namespace app\modules\portfolio\models;

use app\components\ForceActiveRecordErrors;
use app\components\uploader\FileUploadBehavior;
use Override;
use yii\db\ActiveQueryInterface;
use yii\db\ActiveRecord;
use yii\web\UploadedFile;

/**
 * @property int $id
 * @property int $sort
 * @property string $date
 * @property int $category_id
 * @property string $slug
 * @property string $title
 * @property string $meta_title
 * @property string $meta_description
 * @property string $short
 * @property string $text
 * @property string|UploadedFile|null $image
 * @property bool $image_show
 * @property bool $public
 *
 * @property Category $category
 *
 * @mixin FileUploadBehavior
 */
final class Work extends ActiveRecord
{
    use ForceActiveRecordErrors;

    public bool|string $del_image = false;

    #[Override]
    public static function tableName(): string
    {
        return 'portfolio_works';
    }

    #[Override]
    public static function find(): WorkQuery
    {
        return new WorkQuery(self::class);
    }

    /**
     * @psalm-api
     */
    public function getCategory(): ActiveQueryInterface
    {
        return $this->hasOne(Category::class, ['id' => 'category_id']);
    }

    #[Override]
    public function behaviors(): array
    {
        return [
            'ImageUpload' => [
                'class' => FileUploadBehavior::class,
                'fileAttribute' => 'image',
                'storageAttribute' => 'image',
                'deleteAttribute' => 'del_image',
                'filePath' => 'upload/images/portfolio',
            ],
        ];
    }
}
