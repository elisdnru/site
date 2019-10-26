<?php
/** @var $this AdminController */

use app\components\AdminController;
use app\components\widgets\grid\ButtonColumn;
use app\components\widgets\grid\IndentLinkColumn;
use app\components\widgets\grid\LinkColumn;
use app\components\widgets\grid\ToggleColumn;
use app\modules\menu\models\Menu;
use yii\helpers\Url;

/** @var $items Menu[] */
/** @var $model Menu */

$this->title = 'Меню';
$this->params['breadcrumbs'] = [
    'Панель управления' => ['/admin'],
    'Меню',
];

if (Yii::$app->moduleManager->allowed('page')) {
    $this->params['admin'][] = ['label' => 'Страницы', 'url' => ['/page/admin/page/index']];
}
$this->params['admin'][] = ['label' => 'Добавить пункт', 'url' => ['create']];
?>

<p class="floatright"><a href="<?= Url::to(['create']) ?>">Добавить</a></p>

<h1>Пункты меню</h1>

<?php Yii::app()->controller->widget('zii.widgets.grid.CGridView', [
    'id' => 'posts-grid',
    'dataProvider' => $model->search(30),
    'filter' => $model,
    'columns' => [
        [
            'name' => 'sort',
            'htmlOptions' => ['style' => 'width:50px;text-align:center'],
        ],
        [
            'class' => IndentLinkColumn::class,
            'name' => 'title',
        ],
        [
            'class' => LinkColumn::class,
            'name' => 'link',
        ],
        [
            'class' => LinkColumn::class,
            'name' => 'alias',
        ],
        [
            'class' => ToggleColumn::class,
            'name' => 'visible',
            'header' => 'В',
            'filter' => [1 => 'Видимые', 0 => 'Скрытые'],
            'titles' => [1 => 'Видимо', 0 => 'Скрыто'],
            'htmlOptions' => ['style' => 'width:30px;text-align:center'],
        ],
        [
            'class' => ButtonColumn::class,
            'template' => '{view}',
            'viewButtonUrl' => '$data->link',
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
