<?php

DUrlRulesHelper::import('gallery');
Yii::import('application.modules.category.models.*');

/**
 * This is the model class for table "{{gallery_category}}".
 *
 * @property string $image
 * @property string $image_width
 * @property string $image_height
 *
 * @property string $url
 * @property string $imageUrl
 * @property string $imageThumdUrl
 */

class GalleryCategory extends TreeCategory
{
    const IMAGE_WIDTH = 250;
    const IMAGE_PATH = 'upload/images/galleries/categories';

    public $del_image = false;

    public $urlRoute = '/gallery/default/category';
    public $multiLanguage = false;
    public $indent = 0;

	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return GalleryCategory the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{gallery_category}}';
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array_merge(parent::relations(), array(
            'parent' => array(self::BELONGS_TO, 'GalleryCategory', 'parent_id'),
            'photos_count' => array(self::STAT, 'GalleryPhoto', 'category_id'),
            'photos' => array(self::HAS_MANY, 'GalleryPhoto', 'category_id'),
            'child_items' => array(self::HAS_MANY, 'GalleryCategory', 'parent_id',
                'order'=>'child_items.sort ASC'
            ),
            'items_count' => array(self::STAT, 'GalleryPhoto', 'category_id',
                'condition'=>'public = 1',
            ),
		));
	}

    public function attributeLabels()
    {
        return array_merge(parent::attributeLabels(), array(
            'image' => 'Изображение',
        ));
    }

    public function behaviors()
    {
        return array_merge(parent::behaviors(), array(
            'ImageUpload'=>array(
                'class'=>'uploader.components.DFileUploadBehavior',
                'fileAttribute'=>'image',
                'deleteAttribute'=>'del_image',
                'enableWatermark'=>true,
                'filePath'=>self::IMAGE_PATH,
                'defaultThumbWidth'=>self::IMAGE_WIDTH,
                'imageWidthAttribute'=>'image_width',
                'imageHeightAttribute'=>'image_height',
            ),
        ));
    }
}