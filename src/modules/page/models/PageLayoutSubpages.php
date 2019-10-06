<?php

namespace app\modules\page\models;

/**
 * This is the model class for table "{{pagelayout}}".
 *
 * The followings are the available columns in table '{{pagelayout}}':
 * @property integer $id
 * @property string $alias
 * @property string $title
 */
class PageLayoutSubpages extends PageLayout
{

    /**
     * Returns the static model of the specified AR class.
     * @param string $className
     * @return PageLayoutSubpages the static model class
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
        return '{{page_layout_subpages}}';
    }
}
