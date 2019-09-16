<?php
/* @var $this DAdminController */

use app\modules\blog\models\BlogCategory;
use app\modules\blog\models\BlogPost;
use app\modules\blog\models\BlogPostGroup;
use app\modules\main\components\DAdminController;
use app\modules\user\models\User;

/* @var $model BlogPost */
?>

<?php $this->widget('zii.widgets.grid.CGridView', [
    'id' => 'posts-grid',
    'dataProvider' => $model->search(50),
    'filter' => $model,
    'columns' => [
        [
            'name' => 'date',
            'htmlOptions' => ['style' => 'width:130px;text-align:center'],
        ],
        [
            'name' => 'title',
            'class' => \app\modules\main\components\widgets\DLinkColumn::class,
        ],
        [
            'name' => 'category_id',
            'filter' => BlogCategory::model()->getTabList(),
            'value' => '$data->category ? $data->category->fullTitle : ""',
        ],
        [
            'name' => 'author_id',
            'htmlOptions' => ['style' => 'text-align:center'],
            'filter' => CHtml::listData(User::model()->findAll(), 'id', 'username'),
            'value' => '$data->author->username',
        ],
        [
            'name' => 'group_id',
            'header' => 'Группа',
            'filter' => BlogPostGroup::model()->getAssocList(),
            'value' => '$data->group ? $data->group->title : ""',
        ],
        [
            'class' => \app\modules\main\components\widgets\DToggleColumn::class,
            'name' => 'public',
            'header' => 'О',
            'filter' => [1 => 'Опубликовано', 0 => 'Не опубликовано'],
            'titles' => [1 => 'Опубликовано', 0 => 'Не опубликовано'],
            'htmlOptions' => ['style' => 'width:30px;text-align:center'],
        ],
        [
            'class' => \app\modules\main\components\widgets\DButtonColumn::class,
            'template' => '{view}',
        ],
        [
            'class' => \app\modules\main\components\widgets\DButtonColumn::class,
            'template' => '{update}',
        ],
        [
            'class' => \app\modules\main\components\widgets\DButtonColumn::class,
            'template' => '{delete}',
        ],
    ],
]);
