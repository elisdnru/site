<?php

DUrlRulesHelper::import('personnel');
Yii::import('application.modules.category.models.*');

/**
 * This is the model class for table "{{graduate_grade}}".
 *
 * @property integer $id
 * @property integer $year
 * @property integer $number
 * @property string $letter
 * @property string $teacher
 * @property string $image
 *
 * @property GraduateGraduate[] $graduates
 * @property integer $graduates_count
 */

class GraduateGrade extends CActiveRecord
{
    const IMAGE_WIDTH = 250;
    const IMAGE_PATH = 'upload/images/graduate';

    public $del_image = false;

	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return GraduateGrade the static model class
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
		return '{{graduate_grade}}';
	}

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('year', 'required'),
            array('year', 'numerical', 'integerOnly'=>true),
            array('number', 'length', 'max'=>'2'),
            array('letter', 'length', 'max'=>'1'),
            array('teacher', 'length', 'max'=>'255'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, year, number, letter', 'safe', 'on'=>'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        return array(
            'graduates' => array(self::HAS_MANY, 'GraduateGraduate', 'grade_id', 'condition'=>'public = 1'),
            'graduates_count' => array(self::STAT, 'GraduateGraduate', 'grade_id', 'condition'=>'public = 1'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'year' => 'Год',
            'number' => 'Класс',
            'letter' => 'Буква',
            'teacher' => 'Классный руководитель',
            'image' => 'Фото',
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @param int $pageSize
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search($pageSize=10)
    {
        $criteria=new CDbCriteria;

        $criteria->compare('t.id',$this->id);
        $criteria->compare('t.year',$this->year,true);
        $criteria->compare('t.number',$this->number);
        $criteria->compare('t.teacher',$this->teacher);
        $criteria->compare('t.letter',$this->letter);

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
            'pagination'=>array(
                'pageSize'=>$pageSize,
                'pageVar'=>'page',
            ),
        ));
    }

    public function behaviors()
    {
        return array(
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
        );
    }

	protected function afterDelete()
	{
		foreach ($this->graduates as $graduate)
			$graduate->delete();
		parent::afterDelete();
	}

	public function getAssocList()
	{
		/** @var GraduateGrade[] $items */
		$items = $this->findAll(array('order'=>'year ASC, number ASC, letter ASC'));
		$list = array();
		foreach ($items as $item)
			$list[$item->id] = $item->getFullName();
		return $list;
	}

	public function getFullName()
	{
		return trim($this->year . ' ' . ($this->number ? $this->number . ' ' : '') . ($this->letter ? $this->letter . ' ' : ''));
	}

	public function getYearsList()
	{
		$years = $this->getDbConnection()->createCommand('SELECT DISTINCT year FROM ' . $this->tableName() . ' ORDER BY year')->queryColumn();
		$result = array();
		foreach ($years as $year)
			$result[$year] = $year;
		return $result;
	}

	public function getNumbersList()
	{
		return array(
			' '=>'нет',
			9=>9,
			10=>10,
			11=>11
		);
	}

	public function getLettersList()
	{
		return array(
			' '=>'нет',
			'А'=>'А',
			'Б'=>'Б',
			'В'=>'В',
			'Г'=>'Г',
			'Д'=>'Д',
			'Е'=>'Е',
		);
	}

	private $_url;

	public function getUrl()
	{
		if ($this->_url === null)
		{
			$this->_url = Yii::app()->createUrl('/graduate/default/year', array(
				'year'=>$this->year,
			));
		}
		return $this->_url;
	}
}