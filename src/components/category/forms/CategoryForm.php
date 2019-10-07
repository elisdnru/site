<?php

namespace app\components\category\forms;

use app\components\category\models\Category;
use CFormModel;

/**
 * @property string $id
 * @property string $sort
 * @property string $alias
 * @property string $title
 * @property string $text
 * @property string $pagetitle
 * @property string $description
 * @property string $keywords
 * @property string $parent_id
 */
abstract class CategoryForm extends CFormModel
{

    public $id;
    public $sort;
    public $alias;
    public $title;
    public $text;
    public $pagetitle;
    public $description;
    public $keywords;
    public $parent_id;

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        return Category::staticRules();
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {

        return Category::staticAtributeLabels();
    }
}
