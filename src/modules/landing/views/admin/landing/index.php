<?php
use app\widgets\grid\ButtonColumn;
use app\widgets\grid\IndentLinkColumn;
use app\widgets\grid\LinkColumn;
use app\modules\landing\models\Landing;
use yii\helpers\Url;

/** @var $model Landing */

$this->title = 'Лендинги';
$this->params['breadcrumbs'] = [
    'Лендинги',
];

if (Yii::$app->moduleManager->allowed('landing')) {
    $this->params['admin'][] = ['label' => 'Добавить лендинг', 'url' => ['create']];
}
if (Yii::$app->moduleManager->allowed('page')) {
    $this->params['admin'][] = ['label' => 'Страницы', 'url' => ['/page/admin/page/index']];
}
?>

<p class="floatright"><a href="<?= Url::to(['create']) ?>">Добавить</a></p>

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
            'viewButtonUrl' => '$data->getUrl()',
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

