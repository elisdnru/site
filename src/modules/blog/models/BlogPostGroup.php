<?php

Yii::import('application.modules.new.models.*');

/**
 * This is the model class for table "{{new_group}}".
 *
 * The followings are the available columns in table '{{new_group}}':
 * @property integer $id
 * @property string $title
 */
class BlogPostGroup extends NewsGroup
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return BlogPostGroup the static model class
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
		return '{{blog_post_group}}';
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
            'posts' => array(self::HAS_MANY, 'BlogPost', 'group_id',
                'condition'=>'posts.public=1',
                'order'=>'posts.date DESC, posts.id DESC'
            ),
            'posts_count' => array(self::STAT, 'BlogPost', 'group_id'),
		);
	}
}