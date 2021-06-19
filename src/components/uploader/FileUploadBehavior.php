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
 * public $delImage; // field for "Delete image" checkbox
 *
 * public function behaviors(): array
 * {
 *     return [
 *         'ImageUpload' => [
 *             'class'=> FileUploadBehavior::class,
 *             'fileAttribute' => 'image',
 *             'storageAttribute' => 'image',
 *             'deleteAttribute' => 'delImage',
 *             'fileTypes' => ['jpg', 'jpeg', 'gif', 'png'],
 *             'filePath' => 'upload/images',
 *         ]
 *     ];
 * }
 * </pre>
 */
class FileUploadBehavior extends Behavior
{
    public string $fileAttribute = 'file';
    public string $storageAttribute = 'file';
    public string $deleteAttribute = 'delFile';
    public array $fileTypes = ['jpg', 'jpeg', 'gif', 'png'];
    public string $filePath = '';
    public int $defaultThumbWidth = 200;
    public int $defaultThumbHeight = 0;
    public string $imageWidthAttribute = '';
    public string $imageHeightAttribute = '';
    public bool $enableWatermark = false;

    private Uploader $uploader;
    private File $files;
    private Image $images;

    private ?string $cachedImageUrl = null;

    /**
     * @var string[]
     */
    private array $cachedImageThumbUrl = [];

    public function __construct(Uploader $uploader, File $files, Image $images, array $config = [])
    {
        parent::__construct($config);
        $this->uploader = $uploader;
        $this->files = $files;
        $this->images = $images;
    }

    public function attach($owner): void
    {
        parent::attach($owner);

        /** @var ActiveRecord $owner */
        $fileValidator = Validator::createValidator('file', $owner, $this->fileAttribute, [
            'extensions' => $this->fileTypes,
            'skipOnEmpty' => true,
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
        $this->processImageSizes();

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

    public function getImageThumbUrl(int $width = 0, int $height = 0): string
    {
        if (!$width) {
            $width = $this->defaultThumbWidth;
        }
        if (!$height) {
            $height = $this->defaultThumbHeight;
        }

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

    private function processImageSizes(): void
    {
        if ($this->imageWidthAttribute && $this->imageHeightAttribute) {
            $model = $this->getModel();

            $name = (string)$model->{$this->storageAttribute};

            if ($name) {
                $width = $this->defaultThumbWidth;
                $height = $this->defaultThumbHeight;

                $thumbName = $this->uploader->createThumbFileName($name, $width, $height);

                if ($this->uploader->checkThumbExists($this->filePath . \DIRECTORY_SEPARATOR . $thumbName)) {
                    $file = $this->files->set($this->filePath . \DIRECTORY_SEPARATOR . $thumbName);
                } else {
                    $file = $this->uploader->createThumb(
                        $this->filePath,
                        $name,
                        $width,
                        $height
                    );
                }

                if ($file !== null && ($image = $this->images->load($file->getRealPath()))) {
                    $model->{$this->imageWidthAttribute} = $image->getWidth();
                    $model->{$this->imageHeightAttribute} = $image->getHeight();
                }
            }
        }
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
