<?php
/** @var $this AdminController */
/** @var $model \app\modules\blog\models\Tag */

use app\components\AdminController;

$this->pageTitle = 'Метки записей';
$this->breadcrumbs = [
    'Панель управления' => ['/admin'],
    'Записи' => ['/blog/admin/post/index'],
    'Метки записей',
];

$this->admin[] = ['label' => 'Записи', 'url' => $this->createUrl('/blog/admin/post/index')];
$this->admin[] = ['label' => 'Категории', 'url' => $this->createUrl('/blog/admin/category/index')];
$this->admin[] = ['label' => 'Группы', 'url' => $this->createUrl('/blog/admin/group/index')];
$this->admin[] = ['label' => 'Добавить метку', 'url' => $this->createUrl('create')];
?>

<p class="floatright"><a href="<?php echo $this->createUrl('create'); ?>">Добавить</a></p>
<h1>Метки записей блога</h1>

<?php $this->renderPartial('_grid', ['model' => $model]); ?>
