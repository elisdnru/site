<?php

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
class PageFile extends FileModel
{
    const TYPE_OF_FILE = 'page';
    const FILE_PATH = 'upload/files/pages';
    const FILES_LIMIT = 5;

    /**
     * Returns the static model of the specified AR class.
     * @return PageFile the static model class
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
            'material' => [self::BELONGS_TO, \Page::class, 'material_id'],
        ];
    }

    public function init()
    {
        $this->type = self::TYPE_OF_FILE;
        $this->filepath = self::FILE_PATH;
        parent::init();
    }
}
