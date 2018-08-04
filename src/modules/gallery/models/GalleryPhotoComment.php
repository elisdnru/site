<?php

Yii::import('application.modules.gallery.models.*');
Yii::import('application.modules.comment.models.*');
DUrlRulesHelper::import('gallery');

class GalleryPhotoComment extends Comment
{
    const TYPE_OF_COMMENT = 'GalleryPhoto';

    /**
     * Returns the static model of the specified AR class.
     * @return GalleryPhotoComment the static model class
     */
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }

    public function __construct($scenario='insert')
    {
        $this->type_of_comment = self::TYPE_OF_COMMENT;
        parent::__construct($scenario);
    }

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		return array_merge(parent::relations(), array(
            'child_items' => array(self::HAS_MANY, self::TYPE_OF_COMMENT . 'Comment', 'parent_id'),
            'material' => array(self::BELONGS_TO, self::TYPE_OF_COMMENT, 'material_id'),
		));
	}

}