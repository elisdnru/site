<?php

Yii::import('application.modules.new.models.*');
Yii::import('application.modules.comment.models.Comment');
DUrlRulesHelper::import('new');

class NewsComment extends Comment
{
    const TYPE_OF_COMMENT = 'News';

    /**
     * Returns the static model of the specified AR class.
     * @return NewsComment the static model class
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