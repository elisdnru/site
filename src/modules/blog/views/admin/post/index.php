<?php
/** @var $this AdminController */

use app\modules\blog\models\Post;
use app\components\AdminController;

/** @var $model Post */

$this->pageTitle = 'Записи блога';
$this->breadcrumbs = [
    'Панель управления' => ['/admin'],
    'Записи блога',
];

$this->admin = [
    ['label' => 'Добавить', 'url' => $this->createUrl('create')],
    ['label' => 'Категории', 'url' => $this->createUrl('/blog/admin/category/index')],
    ['label' => 'Метки', 'url' => $this->createUrl('/blog/admin/tag/index')],
    ['label' => 'Тематические группы', 'url' => $this->createUrl('/blog/admin/group/index')],
];
?>

<p class="floatright"><a href="<?php echo $this->createUrl('create'); ?>">Добавить</a></p>
<h1>Записи блога</h1>

<?php $this->renderPartial('_grid', ['model' => $model]); ?>
