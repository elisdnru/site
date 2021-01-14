<?php

namespace app\components\uploader;

use app\extensions\file\File;
use app\extensions\image\ImageHandler;
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
 * public $delImage; // field for "Delete image" checkbox
 *
 * public function behaviors(): array
 * {
 *     return [
 *         'ImageUpload' => [
 *             'class'=> FileUploadBehavior::class,
 *             'fileAttribute' => 'image',
 *             'fileTypes' => ['jpg', 'jpeg', 'gif', 'png'],
 *             'deleteAttribute' => 'delImage',
 *             'filePath' => 'upload/images',
 *         ]
 *     ];
 * }
 * </pre>
 *
 */
class FileUploadBehavior extends Behavior
{
    public string $fileAttribute = 'file';
    public array $fileTypes = ['jpg', 'jpeg', 'gif', 'png'];
    public bool $enableWatermark = false;
    public ?string $storageAttribute = null; // set if it different from fileAttribute
    public ?string $deleteAttribute = null; // field for "Delete image" checkbox
    public string $filePath = '';
    public int $defaultThumbWidth = 200;
    public int $defaultThumbHeight = 0;
    public string $imageWidthAttribute = '';
    public string $imageHeightAttribute = '';

    private Uploader $uploader;
    private File $file;
    private ImageHandler $image;

    public function __construct(Uploader $uploader, File $file, ImageHandler $image, array $config = [])
    {
        parent::__construct($config);
        $this->uploader = $uploader;
        $this->file = $file;
        $this->image = $image;
    }

    /**
     * @param ActiveRecord $owner
     */
    public function attach($owner): void
    {
        parent::attach($owner);
        $fileValidator = Validator::createValidator('file', $owner, $this->fileAttribute, [
            'extensions' => $this->fileTypes,
            'skipOnEmpty' => true,
        ]);
        $owner->getValidators()->append($fileValidator);
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
        $this->initAttributes();
        /** @var ActiveRecord $model */
        $model = $this->owner;

        if (isset($model->{$this->deleteAttribute}) && $model->{$this->deleteAttribute}) {
            $this->deleteFile();
            return;
        }

        $this->loadFile();
        $this->processImageSizes();

        if (empty($model->{$this->storageAttribute}) && !empty($model->getOldAttribute($this->storageAttribute))) {
            $model->{$this->storageAttribute} = $model->getOldAttribute($this->storageAttribute);
        }
    }

    public function beforeDelete(): void
    {
        $this->initAttributes();
        $this->deleteFile();
    }

    private ?string $cachedImageUrl = null;

    public function getImageUrl(): string
    {
        $this->initAttributes();
        if ($this->cachedImageUrl === null) {
            $this->cachedImageUrl = '/' . $this->uploader->getUrl($this->filePath, $this->owner->{$this->storageAttribute});
        }
        return $this->cachedImageUrl;
    }

    private array $cachedImageThumbUrl = [];

    public function getImageThumbUrl(int $width = 0, int $height = 0): string
    {
        $this->initAttributes();
        if (!$width) {
            $width = $this->defaultThumbWidth;
        }
        if (!$height) {
            $height = $this->defaultThumbHeight;
        }

        $index = $width . 'x' . $height;

        if (!isset($this->cachedImageThumbUrl[$index])) {
            $fileName = $this->uploader->getThumbUrl($this->filePath, $this->owner->{$this->storageAttribute}, $width, $height);
            $this->cachedImageThumbUrl[$index] = '/' . $fileName;
        }
        return $this->cachedImageThumbUrl[$index];
    }

    private function processImageSizes(): void
    {
        if ($this->imageWidthAttribute && $this->imageHeightAttribute) {
            $model = $this->owner;
            if ($model->{$this->storageAttribute}) {
                $width = $this->defaultThumbWidth;
                $height = $this->defaultThumbHeight;

                $thumbName = $this->uploader->createThumbFileName($this->owner->{$this->storageAttribute}, $width, $height);

                if ($this->uploader->checkThumbExists($this->filePath . DIRECTORY_SEPARATOR . $thumbName)) {
                    $file = $this->file->set($this->filePath . DIRECTORY_SEPARATOR . $thumbName);
                } else {
                    $file = $this->uploader->createThumb($this->filePath, $this->owner->{$this->storageAttribute}, $width, $height);
                }

                if ($file) {
                    if ($image = $this->image->load($file->getRealPath())) {
                        $model->{$this->imageWidthAttribute} = $image->getWidth();
                        $model->{$this->imageHeightAttribute} = $image->getHeight();
                    }
                }
            }
        }
    }

    private function initAttributes(): void
    {
        if (empty($this->storageAttribute)) {
            $this->storageAttribute = $this->fileAttribute;
        }
    }

    private function loadFile(): void
    {
        /** @var ActiveRecord $model */
        $model = $this->owner;

        if (preg_match('|^http:\/\/|', $model->{$this->fileAttribute})) {
            $fileUrl = $model->{$this->fileAttribute};
            $this->deleteFile();

            if ($upload = $this->uploadByUrl($fileUrl)) {
                $model->{$this->fileAttribute} = '';
                $model->{$this->storageAttribute} = $upload->getBasename();
            }
        } elseif ($model->{$this->fileAttribute} instanceof UploadedFile) {
            $uploadedFile = $model->{$this->fileAttribute};
            $this->deleteFile();

            if ($upload = $this->uploadFile($uploadedFile)) {
                $model->{$this->storageAttribute} = $upload->getBasename();
            }
        } elseif ($file = UploadedFile::getInstance($model, $this->fileAttribute)) {
            $this->deleteFile();

            if ($upload = $this->uploadFile($file)) {
                $model->{$this->storageAttribute} = $upload->getBasename();
            }
        }
    }

    private function deleteFile(): void
    {
        $model = $this->owner;
        if ($model->{$this->storageAttribute}) {
            $this->uploader->delete($model->{$this->storageAttribute}, $this->filePath);
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
