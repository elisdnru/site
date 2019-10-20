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
    public $parent_id;

    public function rules(): array
    {
        return Category::staticRules();
    }

    public function attributeLabels(): array
    {
        return Category::staticAtributeLabels();
    }
}
