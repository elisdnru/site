<?php

namespace app\modules\file\models;

use CActiveDataProvider;
use CActiveRecord;
use CDbCriteria;
use CUploadedFile;
use Yii;

/**
 * This is the model class for table "{{comment}}".
 *
 * The followings are the available columns in table '{{comment}}':
 * @property string $id
 * @property integer $type
 * @property integer $material_id
 * @property integer $title
 * @property integer $file
 */
abstract class FileModel extends CActiveRecord
{
    protected $filepath;
    protected $oldfile;

    /**
     * Returns the static model of the specified AR class.
     * @return FileModel the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return '{{file}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return [
            ['material_id, file', 'required'],
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            ['id, material_id, title, file, type', 'safe', 'on' => 'search'],
        ];
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'material_id' => 'Материал',
            'title' => 'Имя файла',
            'file' => 'Файл',
            'type' => 'Тип',
        ];
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search()
    {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.
        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('type', $this->type, true);
        $criteria->compare('material_id', $this->material_id);
        $criteria->compare('title', $this->title, true);
        $criteria->compare('file', $this->file, true);

        return new CActiveDataProvider($this, [
            'criteria' => $criteria,
        ]);
    }

    protected function afterFind()
    {
        $this->oldfile = $this->file;
        parent::afterFind();
    }

    protected function beforeSave()
    {
        if (parent::beforeSave()) {
            if (!$this->type) {
                return false;
            }
            $this->loadFile();
            return true;
        }
        return false;
    }

    protected function loadFile()
    {
        if ($this->file instanceof CUploadedFile) {
            $this->delFile();

            $upload = Yii::app()->uploader->upload($this->file, $this->filepath);
            if ($upload) {
                $this->title = $this->file->name;
                $this->file = $upload->basename;
            }
        }
    }

    protected function beforeDelete()
    {
        if (parent::beforeDelete()) {
            $this->delFile();
            return true;
        }
        return false;
    }

    private function delFile()
    {
        if (!$this->oldfile) {
            return false;
        }

        Yii::app()->uploader->delete($this->oldfile, $this->filepath);
        $this->file = '';
        return true;
    }
}
