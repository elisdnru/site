<?php

declare(strict_types=1);

namespace app\components\uploader;

use app\extensions\file\File;
use app\extensions\image\Image;
use ArrayObject;
use yii\base\Behavior;
use yii\db\ActiveRecord;
use yii\validators\Validator;
use yii\web\UploadedFile;

/**
 * FileUploadBehavior will automatically load image to model.
 *
 * Purify source when the active record
 * is created and/or updated.
 * You may specify an active record model to use this behavior like so:
 * <pre>
 * public $del_image; // field for "Delete image" checkbox
 *
 * public function behaviors(): array
 * {
 *     return [
 *         'ImageUpload' => [
 *             'class'=> FileUploadBehavior::class,
 *             'fileAttribute' => 'image',
 *             'storageAttribute' => 'image',
 *             'deleteAttribute' => 'del_image',
 *             'fileTypes' => ['jpg', 'jpeg', 'gif', 'png'],
 *             'filePath' => 'upload/images',
 *         ]
 *     ];
 * }
 * </pre>
 */
final class FileUploadBehavior extends Behavior
{
    public string $fileAttribute = 'file';
    public string $storageAttribute = 'file';
    public string $deleteAttribute = 'delFile';
    public array $fileTypes = ['jpg', 'jpeg', 'gif', 'png'];
    public string $filePath = '';

    private Uploader $uploader;

    private ?string $cachedImageUrl = null;

    /**
     * @var string[]
     */
    private array $cachedImageThumbUrl = [];

    public function __construct(Uploader $uploader, array $config = [])
    {
        parent::__construct($config);
        $this->uploader = $uploader;
    }

    public function attach($owner): void
    {
        parent::attach($owner);

        /** @var ActiveRecord $owner */
        $fileValidator = Validator::createValidator('file', $owner, $this->fileAttribute, [
            'extensions' => $this->fileTypes,
            'skipOnEmpty' => true,
            // TODO: remove after https://github.com/yiisoft/yii2/pull/19246 release
            'checkExtensionByMimeType' => false,
        ]);
        /** @var ArrayObject $validators */
        $validators = $owner->getValidators();
        $validators->append($fileValidator);
    }

    public function events(): array
    {
        return [
            ActiveRecord::EVENT_BEFORE_INSERT => 'beforeSave',
            ActiveRecord::EVENT_BEFORE_UPDATE => 'beforeSave',
            ActiveRecord::EVENT_BEFORE_DELETE => 'beforeDelete',
        ];
    }

    public function beforeSave(): void
    {
        $model = $this->getModel();

        if (isset($model->{$this->deleteAttribute}) && $model->{$this->deleteAttribute}) {
            $this->deleteFile();
            return;
        }

        $this->loadFile();

        if (empty($model->{$this->storageAttribute}) && !empty($model->getOldAttribute($this->storageAttribute))) {
            $model->{$this->storageAttribute} = $model->getOldAttribute($this->storageAttribute);
        }
    }

    public function beforeDelete(): void
    {
        $this->deleteFile();
    }

    public function getImageUrl(): string
    {
        if ($this->cachedImageUrl === null) {
            $name = (string)$this->getModel()->{$this->storageAttribute};
            $this->cachedImageUrl = '/' . $this->uploader->getUrl($this->filePath, $name);
        }
        return $this->cachedImageUrl;
    }

    public function getImageThumbUrl(int $width, int $height): string
    {
        $index = $width . 'x' . $height;

        if (!isset($this->cachedImageThumbUrl[$index])) {
            $name = (string)$this->getModel()->{$this->storageAttribute};
            $fileName = $this->uploader->getThumbUrl($this->filePath, $name, $width, $height);
            $this->cachedImageThumbUrl[$index] = '/' . $fileName;
        }

        return $this->cachedImageThumbUrl[$index];
    }

    protected function getModel(): ActiveRecord
    {
        /** @var ActiveRecord */
        return $this->owner;
    }

    private function loadFile(): void
    {
        $model = $this->getModel();

        /** @var string|UploadedFile $file */
        $file = $model->{$this->fileAttribute};

        if (\is_string($file) && preg_match('|^http://|', $file)) {
            $this->deleteFile();
            if ($upload = $this->uploadByUrl($file)) {
                $model->{$this->fileAttribute} = '';
                $model->{$this->storageAttribute} = $upload->getBasename();
            }
            return;
        }

        if ($file instanceof UploadedFile) {
            $this->deleteFile();
            if ($upload = $this->uploadFile($file)) {
                $model->{$this->storageAttribute} = $upload->getBasename();
            }
            return;
        }

        if ($file = UploadedFile::getInstance($model, $this->fileAttribute)) {
            $this->deleteFile();
            if ($upload = $this->uploadFile($file)) {
                $model->{$this->storageAttribute} = $upload->getBasename();
            }
        }
    }

    private function deleteFile(): void
    {
        $model = $this->getModel();
        $name = (string)$model->{$this->storageAttribute};
        if ($name) {
            $this->uploader->delete($name, $this->filePath);
            if (isset($model->{$this->deleteAttribute})) {
                $model->{$this->deleteAttribute} = false;
            }
            $model->{$this->storageAttribute} = '';
        }
    }

    private function uploadByUrl(string $fileUrl): ?File
    {
        return $this->uploader->uploadByUrl($fileUrl, $this->filePath, 'jpg');
    }

    private function uploadFile(UploadedFile $uploadedFile): ?File
    {
        return $this->uploader->upload($uploadedFile, $this->filePath);
    }
}
