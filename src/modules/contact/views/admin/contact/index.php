<?php
/** @var $this AdminController */

use app\modules\contact\models\Contact;
use app\components\AdminController;

/** @var $model Contact */

$this->title = 'Сообщения';
$this->breadcrumbs = [
    'Панель управления' => ['/admin'],
    'Сообщения',
];

if (Yii::app()->moduleManager->allowed('comment')) {
    $this->admin[] = ['label' => 'Комментарии', 'url' => $this->createUrl('/comment/admin/comment/index')];
}
?>

<h1>Сообщения</h1>

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
            'name' => 'name',
            'htmlOptions' => ['style' => 'text-align:center'],
        ],
        [
            'name' => 'email',
            'htmlOptions' => ['style' => 'text-align:center'],
        ],
        [
            'name' => 'text',
            'value' => static function ($data) {
                return CHtml::link(CHtml::encode(mb_substr($data->text, 0, 59, 'UTF-8')), Yii::app()->controller->createUrl('view', ['id' => $data->id]));
            },
            'type' => 'html',
        ],
        [
            'name' => 'pagetitle',
        ],
        [
            'class' => \app\components\widgets\grid\ToggleColumn::class,
            'name' => 'status',
            'header' => 'П',
            'filter' => [1 => 'Прочитано', 0 => 'Новое'],
            'titles' => [1 => 'Прочитано', 0 => 'Новое'],
            'htmlOptions' => ['style' => 'width:30px;text-align:center'],
            'offImageUrl' => '/images/admin/message.png',
        ],
        [
            'class' => \app\components\widgets\grid\ButtonColumn::class,
            'template' => '{view}',
        ],
        [
            'class' => \app\components\widgets\grid\ButtonColumn::class,
            'template' => '{delete}',
        ],
    ],
]);

