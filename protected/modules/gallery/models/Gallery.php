<?php

Yii::import('application.modules.uploader.components.DFileHelper');

/**
 * This is the model class for table "{{gallery}}".
 *
 * The followings are the available columns in table '{{gallery}}':
 * @property integer $id
 * @property string $title
 * @property string $alias
 */
class Gallery extends CActiveRecord
{
    const GALLERY_PATH = 'upload/gallery';
    const THUMB_IMAGE_WIDTH = 84;

    private $oldalias = '';

	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Gallery the static model class
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
		return '{{gallery}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('title, alias', 'required'),
			array('title, alias', 'length', 'max'=>255),
            array('alias', 'match', 'pattern' => '#^\w[a-zA-Z0-9_-]+$#', 'message' => 'Допустимы только латинские символы, цифры и знак подчёркивания'),
            array('alias', 'unique', 'caseSensitive' => false, 'message' => 'Такой {attribute} уже используется'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, title, alias', 'safe', 'on'=>'search'),
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
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'title' => 'Внутреннее название галереи',
			'alias' => 'Псевдоним',
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
		$criteria->compare('alias',$this->alias,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

    protected function afterFind()
    {
        $this->oldalias = $this->alias;
        parent::afterFind();
    }

    protected function beforeDelete()
    {
        if (parent::beforeDelete())
        {
            if ($this->alias)
            {
                $path = $this->getFileDir();
                Yii::app()->file->set($path)->Delete();
            }
            return true;
        }
        return false;
    }

    protected function beforeSave()
    {
        if (parent::beforeSave())
        {
            if ($this->isNewRecord && $this->alias)
                $this->createDirectory();
            return true;
        }
        return false;
    }

    protected function afterSave()
    {
        if ($this->oldalias && $this->oldalias != $this->alias)
            $this->renameDirectory();

        parent::afterSave();
    }

    public function getAssocList()
    {
        $items = $this->findAll(array('order'=>'title'));
        $result = array();

        foreach ($items as $item)
            $result[$item->id] = $item->title;

        return $result;
    }

    public function uploadPostFile($field)
    {
        $success = true;

        $curpath = $this->getFileDir();

        $uploaded = Yii::app()->file->set($field, true);

        if ($uploaded)
        {
            if (!$this->isCorrectExtension($uploaded->extension))
                return 'Неподходящий тип файла';

            if ($uploaded->basename == '.htaccess')
                return 'Отказано в доступе к загрузке файла .htaccess';

            $filename = DTextHelper::strToChpu($uploaded->filename) . '.' . $uploaded->extension;

            $success = $uploaded->Move($curpath.'/'.$filename);

            $this->createThumb($filename);
        }

        return $success;
    }

    public function createThumbs()
    {
        $files = $this->getFileList();

        foreach ($files as $item)
        {
            $file = Yii::app()->file->set($item);
            if ($this->isCorrectExtension($file->extension) && !preg_match('/_prev$/', $file->filename, $t))
                $this->createThumb($file->basename);
        }
    }

    public function createThumb($name)
    {
        if (!$this->isFileExists($name)) return false;

        $file = Yii::app()->file->set($this->getFileDir().'/'.$name);

        if ($this->isCorrectExtension($file->extension))
        {
            $orig = Yii::app()->image->load($this->getFileDir() . '/' . $file->basename);
            $prevname = $this->getFileDir() . '/' . $file->filename . '_prev.' . $file->extension;

            if ($orig->width > self::THUMB_IMAGE_WIDTH)
                $orig->thumb(self::THUMB_IMAGE_WIDTH, 1000)->save($prevname, false, 90);
            else
                $orig->save($prevname);
        }

        return true;
    }

    public function clearThumbs()
    {
        $files = $this->getFileList();

        foreach ($files as $item)
        {
            $file = Yii::app()->file->set($item);
            if (preg_match('/_prev$/', $file->filename, $t))
                $this->deleteFile($file->basename);
        }
    }

    public function isFileExists($filename)
    {
        if ($filename)
        {
            $file = $this->getFileDir() . '/' . $filename;
            return Yii::app()->file->set($file)->exists;
        } else
            return false;
    }

    public function deleteFile($name)
    {
        $name = DFileHelper::escape($name);

        $this->deleteThumb($name);
        $orig = Yii::app()->file->set($this->getFileDir() . '/' . $name);

        return $orig->delete();
    }

    protected function deleteThumb($name)
    {
        $orig = Yii::app()->file->set($this->getFileDir() . '/' . $name);
        if (!preg_match('/_prev$/', $orig->filename, $t))
        {
            $prevname = $orig->filename . '_prev.' . $orig->extension;

            if ($this->isFileExists($prevname))
            {
                $prev = Yii::app()->file->set($this->getFileDir() . '/' . $prevname);
                $prev->delete();
            }
        }
    }

    public function renameFile($name, $to)
    {
        $currentName = DFileHelper::escape($name);
        $newName = DFileHelper::escape($to);

        if (!$currentName || !$newName)
            return false;

        $this->deleteThumb($name);

        $currentFile = Yii::app()->file->set($this->getFileDir() . '/' . $currentName, true);
        if (!$currentFile)
            return false;

        $this->deleteThumb($name);
        $currentFile->rename($newName);
        $this->createThumb($newName);

        return true;
    }

    public function getFileList()
    {
        $dir = Yii::app()->file->set($this->getFileDir());
        return $dir->contents;
    }

    public function getFileNameList()
    {
        $dir = Yii::app()->file->set($this->getFileDir());
        $list = array();

        foreach ($dir->contents as $file)
        {
            $file = str_replace('\\', '/', $file);
            $array = explode('/', $file);
            $list[] = array_pop($array);
        };

        return $list;
    }

    public function getFileDir($alias = '')
    {
        return self::GALLERY_PATH.'/'.($alias ? $alias : $this->alias);
    }

    protected function isCorrectExtension($extension)
    {
        return in_array(mb_strtolower($extension, 'UTF-8'), array('jpg', 'jpeg', 'png', 'gif'));
    }

    public function findByAlias($alias)
    {
        $model = $this->find(array(
            'condition'=>'alias = :alias',
            'params'=>array(':alias'=>$alias)
        ));
        return $model;
    }

    protected function renameDirectory()
    {
        $oldname = $this->getFileDir($this->oldalias);
        $newname = $this->alias;

        $dir = Yii::app()->file->set($oldname);

        if ($dir->exists)
            $dir->Rename($newname);
        else
            Yii::app()->file->CreateDir(0754, $this->getFileDir($newname));
    }

    protected function createDirectory()
    {
        $path = $this->getFileDir();
        Yii::app()->file->CreateDir(0754, $path);
    }

}