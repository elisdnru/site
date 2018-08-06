<?php

Yii::import('application.modules.file.models.FileModel');

/**
 * This is the model class for table "{{profsoyuz_category}}".
 *
 * The followings are the available columns in table '{{profsoyuz_category}}':
 * @property string $id
 * @property string $material_id
 * @property string $title
 * @property string $name
 * @property string $type
 */
class NewsFile extends FileModel
{
    const TYPE_OF_FILE = 'news';
    const FILE_PATH = 'upload/files/news';
    const FILES_LIMIT = 5;

    /**
     * Returns the static model of the specified AR class.
     * @return NewsFile the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        return [
            'material' => [self::BELONGS_TO, 'News', 'material_id'],
        ];
    }

    public function init()
    {
        $this->type = self::TYPE_OF_FILE;
        $this->filepath = self::FILE_PATH;
        parent::init();
    }
}
