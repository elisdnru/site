<?php

DUrlRulesHelper::import('blog');

/**
 * This is the model class for table "{{blog_tag}}".
 *
 * The followings are the available columns in table '{{blog_tag}}':
 * @property integer $id
 * @property string $title
 */
class BlogTag extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return BlogTag the static model class
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
		return '{{blog_tag}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('title', 'required'),
			array('title', 'length', 'max'=>255),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, title', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
            'frequency' => array(self::STAT, 'BlogPostTag', 'tag_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'title' => 'Метка',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('title',$this->title,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

    public function getAssocList()
    {
        $items = $this->findAll(array('order'=>'title'));
        $result = array();
        foreach ($items as $item){
            $result[$item->id] = $item->title;
        }
        return $result;
    }

    public function findOrCreateByTitle($title)
    {
        $tag = $this->findByTitle($title);
        if (!$tag){
            $tag = new BlogTag;
            $tag->title = $title;
            $tag->save();
        }
        return $tag;
    }

    public function getPostIds()
    {
        $postIds = Yii::app()->db
            ->createCommand('SELECT post_id FROM {{blog_post_tag}} WHERE tag_id=:tag')
            ->queryColumn(array(':tag'=>$this->id));

        return array_unique($postIds);
    }

    public function getArrayByMatch($q)
    {
        $titles = Yii::app()->db
            ->createCommand('SELECT title FROM {{blog_tag}} WHERE title LIKE :tag')
            ->queryColumn(array(':tag'=>$q . '%'));

        return array_unique($titles);
    }

    public function findByTitle($title)
    {
        $tag = $this->find(array(
            'condition' => 'title = :title',
            'params' => array(':title'=>$title),
        ));

        return $tag;
    }

    private $_url;

    public function getUrl()
    {
        if ($this->_url === null)
        {
            DUrlRulesHelper::import('blog');
            $this->_url = Yii::app()->createUrl('/blog/default/tag', array('tag'=>$this->title));
        }

        return $this->_url;
    }


}