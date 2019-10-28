<?php
/** @var $model Page */

use app\components\widgets\grid\ButtonColumn;
use app\components\widgets\grid\IndentLinkColumn;
use app\components\widgets\grid\LinkColumn;
use app\modules\page\models\Page;
use yii\helpers\Url;

$this->title = 'Страницы';
$this->params['breadcrumbs'] = [
    'Страницы',
];

if (Yii::$app->moduleManager->allowed('page')) {
    $this->params['admin'][] = ['label' => 'Добавить страницу', 'url' => ['create']];
}
if (Yii::$app->moduleManager->allowed('menu')) {
    $this->params['admin'][] = ['label' => 'Пункты меню', 'url' => ['/menu/admin/menu/index']];
}
?>

<p class="floatright"><a href="<?= Url::to(['create']) ?>">Добавить</a></p>

<h1>Страницы</h1>

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

