<?php
/**
 * DFileUploadBehavior will automatically load image to model.
 *
 * Purify source when the active record
 * is created and/or upadated.
 * You may specify an active record model to use this behavior like so:
 * <pre>
 * public $del_image; // field for "Delete image" checkbox
 *
 * public function behaviors()
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
 * @author ElisDN <mail@elisdn.ru>
 * @link http://www.elisdn.ru
 */

class DFileUploadBehavior extends CActiveRecordBehavior
{
	public $fileAttribute = 'file';
    public $fileTypes = 'jpg,jpeg,gif,png';
    public $storageAttribute = null; // set if it different from fileAttribute
    public $deleteAttribute = null; // field for "Delete image" checkbox
    public $filePath = '';
    public $defaultThumbWidth = 200;
    public $defaultThumbHeight = 0;
    public $imageWidthAttribute = '';
    public $imageHeightAttribute = '';

    /**
     * @param CComponent $owner
     */
    public function attach($owner){
        parent::attach($owner);
        $fileValidator = CValidator::createValidator('file', $owner, $this->fileAttribute,  array(
            'types'=>$this->fileTypes,
            'allowEmpty'=>true,
            'safe'=>false,
        ));
        $owner->validatorList->add($fileValidator);
    }

	/**
	* Responds to {@link CModel::onBeforeSave} event.
	* @param CModelEvent $event event parameter
	*/
	public function beforeSave($event)
    {
        $this->initAttributes();
        $model = $this->getOwner();
        if (isset($model->{$this->deleteAttribute}) && $model->{$this->deleteAttribute})
            $this->deleteFile();
        $this->loadFile();
        $this->processImageSizes();
	}

    /**
     * Responds to {@link CModel::onBeforeDelete} event.
     * @param CModelEvent $event event parameter
     */
    public function beforeDelete($event)
    {
        $this->initAttributes();
        $this->deleteFile();
    }

    protected $_imageUrl;

    public function getImageUrl()
    {
        $this->initAttributes();
        if ($this->_imageUrl === null)
            $this->_imageUrl = Yii::app()->request->baseUrl . '/' . Yii::app()->uploader->getUrl($this->filePath, $this->getOwner()->{$this->storageAttribute});
        return $this->_imageUrl;
    }

    protected $_imageThumbUrl=array();

    public function getImageThumbUrl($width=0, $height=0)
    {
        $this->initAttributes();
        if (!$width) $width = $this->defaultThumbWidth;
        if (!$height) $height = $this->defaultThumbHeight;

        $index = $width . 'x' . $height;

        if (!isset($this->_imageThumbUrl[$index]))
        {
            $fileName = Yii::app()->uploader->getThumbUrl($this->filePath, $this->getOwner()->{$this->storageAttribute}, $width, $height);
            $this->_imageThumbUrl[$index] = Yii::app()->request->baseUrl . '/' . $fileName;
        }
        return $this->_imageThumbUrl[$index];
    }

    protected function processImageSizes()
    {
        if ($this->imageWidthAttribute && $this->imageHeightAttribute)
        {
            $model = $this->getOwner();
            if ($model->{$this->storageAttribute})
            {
                $width = $this->defaultThumbWidth;
                $height = $this->defaultThumbHeight;

                $thumbName = Yii::app()->uploader->createThumbFileName($this->getOwner()->{$this->storageAttribute}, $width, $height);

                if (Yii::app()->uploader->checkThumbExists($this->filePath . DIRECTORY_SEPARATOR . $thumbName))
                    $file = Yii::app()->file->set($this->filePath . DIRECTORY_SEPARATOR . $thumbName);
                else
                    $file = Yii::app()->uploader->createThumb($this->filePath, $this->getOwner()->{$this->storageAttribute}, $width, $height);

				if ($file)
				{
					if ($image = Yii::app()->image->load($file->getRealPath()))
					{
						$model->{$this->imageWidthAttribute} = $image->getWidth();
						$model->{$this->imageHeightAttribute} = $image->getHeight();
					}
				}
            }
        }
    }

    protected function initAttributes()
    {
        if (empty($this->storageAttribute))
            $this->storageAttribute = $this->fileAttribute;
    }

    protected function loadFile()
    {
        $model = $this->getOwner();

        if (preg_match('|^http:\/\/|', $model->{$this->fileAttribute}))
        {
            $fileUrl = $model->{$this->fileAttribute};
            $this->deleteFile();
            $upload = Yii::app()->uploader->uploadByUrl($fileUrl, $this->filePath, 'jpg');

            if ($upload)
            {
                $model->{$this->fileAttribute} = '';
                $model->{$this->storageAttribute} = $upload->basename;
            }
        }
        elseif ($model->{$this->fileAttribute} instanceof CUploadedFile)
        {
            $uploadedFile = $model->{$this->fileAttribute};
            $this->deleteFile();
            $upload = Yii::app()->uploader->upload($uploadedFile, $this->filePath);

            if ($upload)
            {
                $model->{$this->storageAttribute} = $upload->basename;
            }
        }
        elseif ($file = CUploadedFile::getInstance($model, $this->fileAttribute))
        {
            $this->deleteFile();
            $upload = Yii::app()->uploader->upload($file, $this->filePath);

            if ($upload)
            {
                $model->{$this->storageAttribute} = $upload->basename;
            }
        }
    }

    protected function deleteFile()
    {
        $model = $this->getOwner();
        if ($model->{$this->storageAttribute})
        {
            Yii::app()->uploader->delete($model->{$this->storageAttribute}, $this->filePath);
            if (isset($model->{$this->deleteAttribute}))
                $model->{$this->deleteAttribute} = false;
            $model->{$this->storageAttribute} = '';
        }
    }
}