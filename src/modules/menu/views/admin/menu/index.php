<?php
/** @var $this AdminController */

use app\components\AdminController;
use app\modules\menu\models\Menu;

/** @var $items Menu[] */
/** @var $model Menu */

$this->title = 'Меню';
$this->breadcrumbs = [
    'Панель управления' => ['/admin'],
    'Меню',
];

if (Yii::app()->moduleManager->allowed('page')) {
    $this->admin[] = ['label' => 'Страницы', 'url' => $this->createUrl('/page/admin/page/index')];
}
$this->admin[] = ['label' => 'Добавить пункт', 'url' => $this->createUrl('create')];
?>

<p class="floatright"><a href="<?php echo $this->createUrl('create'); ?>">Добавить</a></p>

<h1>Пункты меню</h1>

<?php $this->widget('zii.widgets.grid.CGridView', [
    'id' => 'posts-grid',
    'dataProvider' => $model->search(30),
    'filter' => $model,
    'columns' => [
        [
            'name' => 'sort',
            'htmlOptions' => ['style' => 'width:50px;text-align:center'],
        ],
        [
            'class' => \app\components\widgets\grid\IndentLinkColumn::class,
            'name' => 'title',
        ],
        [
            'class' => \app\components\widgets\grid\LinkColumn::class,
            'name' => 'link',
        ],
        [
            'class' => \app\components\widgets\grid\LinkColumn::class,
            'name' => 'alias',
        ],
        [
            'class' => \app\components\widgets\grid\ToggleColumn::class,
            'name' => 'visible',
            'header' => 'В',
            'filter' => [1 => 'Видимые', 0 => 'Скрытые'],
            'titles' => [1 => 'Видимо', 0 => 'Скрыто'],
            'htmlOptions' => ['style' => 'width:30px;text-align:center'],
        ],
        [
            'class' => \app\components\widgets\grid\ButtonColumn::class,
            'template' => '{view}',
            'viewButtonUrl' => '$data->link',
        ],
        [
            'class' => \app\components\widgets\grid\ButtonColumn::class,
            'template' => '{update}',
        ],
        [
            'class' => \app\components\widgets\grid\ButtonColumn::class,
            'template' => '{delete}',
        ],
    ],
]);
