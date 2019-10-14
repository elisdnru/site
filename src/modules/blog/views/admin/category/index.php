<?php
/** @var $this AdminController */
/** @var $model \app\modules\blog\models\Category */

use app\components\AdminController;

$this->pageTitle = 'Категории записей';
$this->breadcrumbs = [
    'Панель управления' => ['/admin'],
    'Записи' => ['/blog/admin/post/index'],
    'Категории записей',
];

$this->admin[] = ['label' => 'Записи', 'url' => $this->createUrl('/blog/admin/post/index')];
$this->admin[] = ['label' => 'Группы', 'url' => $this->createUrl('/blog/admin/group/index')];
$this->admin[] = ['label' => 'Добавить категорию', 'url' => $this->createUrl('create')];
?>

<p class="floatright"><a href="<?php echo $this->createUrl('create'); ?>">Добавить</a></p>
<h1>Категории блога</h1>

<?php $this->renderPartial('_grid', ['model' => $model]); ?>
