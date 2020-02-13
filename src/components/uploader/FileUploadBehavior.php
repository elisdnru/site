<?php

namespace app\components\uploader;

use app\extensions\file\File;
use Yii;
use yii\base\Behavior;
use yii\base\ModelEvent;
use yii\db\ActiveRecord;
use yii\validators\Validator;
use yii\web\UploadedFile;

/**
 * DFileUploadBehavior will automatically load image to model.
 *
 * Purify source when the active record
 * is created and/or upadated.
 * You may specify an active record model to use this behavior like so:
 * <pre>
 * public $del_image; // field for "Delete image" checkbox
 *
 * public function behaviors(): array
 * {
 *     return array(
 *         'ImageUpload'=>array(
 *             'class'=>'DFileUploadBehavior',
 *             'fileAttribute'=>'image',
 *             'fileTypes'=>'jpg,jpeg,gif,png',
 *             'deleteAttribute'=>'del_image',
 *             'filePath'=>'upload/images',
 *         )
 *     );
 * }
 * </pre>
 *
 */
class FileUploadBehavior extends Behavior
{
    public $fileAttribute = 'file';
    public $fileTypes = ['jpg', 'jpeg', 'gif', 'png'];
    public $enableWatermark = false;
    public $storageAttribute; // set if it different from fileAttribute
    public $deleteAttribute; // field for "Delete image" checkbox
    public $filePath = '';
    public $defaultThumbWidth = 200;
    public $defaultThumbHeight = 0;
    public $imageWidthAttribute = '';
    public $imageHeightAttribute = '';

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

    /**
     * Responds to {@link CModel::onBeforeSave} event.
     * @param ModelEvent $event event parameter
     */
    public function beforeSave($event): void
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

    /**
     * Responds to {@link CModel::onBeforeDelete} event.
     * @param ModelEvent $event event parameter
     */
    public function beforeDelete($event): void
    {
        $this->initAttributes();
        $this->deleteFile();
    }

    private $cachedImageUrl;

    public function getImageUrl(): string
    {
        $this->initAttributes();
        if ($this->cachedImageUrl === null) {
            $this->cachedImageUrl = '/' . Yii::$app->uploader->getUrl($this->filePath, $this->owner->{$this->storageAttribute});
        }
        return $this->cachedImageUrl;
    }

    private $cachedImageThumbUrl = [];

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
            $fileName = Yii::$app->uploader->getThumbUrl($this->filePath, $this->owner->{$this->storageAttribute}, $width, $height);
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

                $thumbName = Yii::$app->uploader->createThumbFileName($this->owner->{$this->storageAttribute}, $width, $height);

                if (Yii::$app->uploader->checkThumbExists($this->filePath . DIRECTORY_SEPARATOR . $thumbName)) {
                    $file = Yii::$app->file->set($this->filePath . DIRECTORY_SEPARATOR . $thumbName);
                } else {
                    $file = Yii::$app->uploader->createThumb($this->filePath, $this->owner->{$this->storageAttribute}, $width, $height);
                }

                if ($file) {
                    if ($image = Yii::$app->image->load($file->getRealPath())) {
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
            Yii::$app->uploader->delete($model->{$this->storageAttribute}, $this->filePath);
            if (isset($model->{$this->deleteAttribute})) {
                $model->{$this->deleteAttribute} = false;
            }
            $model->{$this->storageAttribute} = '';
        }
    }

    private function uploadByUrl(string $fileUrl): ?File
    {
        return Yii::$app->uploader->uploadByUrl($fileUrl, $this->filePath, 'jpg');
    }

    private function uploadFile(UploadedFile $uploadedFile): ?File
    {
        return Yii::$app->uploader->upload($uploadedFile, $this->filePath);
    }
}
