<?php

Yii::import('application.modules.graduate.models.GraduateGrade');

/**
 * This is the model class for table "{{graduate_graduate}}".
 *
 * The followings are the available columns in table '{{graduate_graduate}}':
 * @property integer $id
 * @property string $grade_id
 * @property string $firstname
 * @property string $middlename
 * @property string $lastname
 * @property string $link
 * @property integer $public
 * @property integer $reward
 *
 * @property string $url
 *
 * @method GraduateGraduate published()
 */
class GraduateGraduate extends CActiveRecord
{
	const REWARD_NONE = 0;
	const REWARD_SILVER = 1;
	const REWARD_GOLD = 2;

	public $year = '';
	public $number = '';
	public $letter = '';

    /**
     * Returns the static model of the specified AR class.
     * @param string $className
     * @return GraduateGraduate the static model class
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
		return '{{graduate_graduate}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('grade_id, firstname, lastname', 'required'),
			array('public, reward', 'numerical', 'integerOnly'=>true),
            array('grade_id', 'DExistOrEmpty', 'className' => 'GraduateGrade', 'attributeName' => 'id'),
            array('firstname, middlename, lastname', 'length', 'max'=>'255'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, grade_id, firstname, middlename, lastname, link, reward, public, year, number, letter', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		return array(
			'grade' => array(self::BELONGS_TO, 'GraduateGrade', 'grade_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'grade_id' => 'Класс',
			'firstname' => 'Имя',
			'middlename' => 'Отчество',
			'lastname' => 'Фамилия',
			'link' => 'Ссылка',
			'reward' => 'Медаль',
			'public' => 'Опубликовано',
			'year' => 'Год',
			'number' => 'Класс',
			'letter' => 'Буква',
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
		$criteria->with = array('grade');

        $criteria->compare('t.id',$this->id);
        $criteria->compare('t.grade_id',$this->grade_id);
        $criteria->compare('t.firstname',$this->firstname,true);
        $criteria->compare('t.middlename',$this->middlename,true);
        $criteria->compare('t.lastname',$this->lastname,true);
        $criteria->compare('t.link',$this->link,true);
        $criteria->compare('t.reward',$this->reward);
        $criteria->compare('t.public',$this->public);
        $criteria->compare('grade.year',$this->year);
        $criteria->compare('grade.number',$this->number);
        $criteria->compare('grade.letter',$this->letter);

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
            'pagination'=>array(
                'pageSize'=>$pageSize,
                'pageVar'=>'page',
            ),
            'sort'=>array(
                'defaultOrder'=>'lastname ASC, firstname ASC, middlename ASC',
            ),
        ));
    }

    public function scopes()
    {
        return array(
            'published'=>array(
                'condition'=>'t.public=1',
            ),
        );
    }

    public function getFullName()
    {
        return trim($this->lastname . ' ' . $this->firstname . ' ' . $this->middlename);
    }

    public function getUrl()
    {
        return $this->link;
    }

	public function getRewardsList()
	{
		return array(
			self::REWARD_GOLD => 'Золотая',
			self::REWARD_SILVER => 'Серебряная',
		);
	}

	public function getRewardsAliasesList()
	{
		return array(
			self::REWARD_GOLD => 'gold',
			self::REWARD_SILVER => 'silver',
		);
	}

	public function getRewardName()
	{
		$names = $this->getRewardsList();
		return isset($names[$this->reward]) ? $names[$this->reward] : '';
	}

	public function getRewardAlias()
	{
		$names = $this->getRewardsAliasesList();
		return isset($names[$this->reward]) ? $names[$this->reward] : '';
	}
}