<?php
/** @var $model Landing */

use app\components\widgets\grid\ButtonColumn;
use app\components\widgets\grid\IndentLinkColumn;
use app\components\widgets\grid\LinkColumn;
use app\modules\landing\models\Landing;

$this->title = 'Лендинги';
$this->params['breadcrumbs'] = [
    'Панель управления' => ['/admin'],
    'Лендинги',
];

if (Yii::app()->moduleManager->allowed('landing')) {
    $this->params['admin'][] = ['label' => 'Добавить лендинг', 'url' => $this->createUrl('create')];
}
if (Yii::app()->moduleManager->allowed('page')) {
    $this->params['admin'][] = ['label' => 'Страницы', 'url' => $this->createUrl('/page/admin/page/index')];
}
?>

<p class="floatright"><a href="<?= $this->createUrl('create') ?>">Добавить</a></p>

<h1>Лендинги</h1>

<?php Yii::app()->controller->widget('zii.widgets.grid.CGridView', [
    'id' => 'posts-grid',
    'dataProvider' => $model->search(30),
    'filter' => $model,
    'columns' => [
        [
            'class' => IndentLinkColumn::class,
            'name' => 'alias',
        ],
        [
            'class' => LinkColumn::class,
            'name' => 'title',
        ],
        [
            'class' => ButtonColumn::class,
            'template' => '{view}',
            'viewButtonUrl' => '$data->url',
        ],
        [
            'class' => ButtonColumn::class,
            'template' => '{update}',
        ],
        [
            'class' => ButtonColumn::class,
            'template' => '{delete}',
        ],
    ],
]);

