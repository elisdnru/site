<?php
/* @var $this DController */

use app\modules\main\components\DController;
use app\modules\main\components\helpers\DNumberHelper;

/* @var $page Page */
/* @var $category BlogCategory */
/* @var $dataProvider CActiveDataProvider */

$this->pageTitle = $category->pagetitle . ' - ' . $page->pagetitle . DNumberHelper::pageString($dataProvider->getPagination()->pageVar);
$this->description = $category->description . DNumberHelper::pageString($dataProvider->getPagination()->pageVar);
$this->keywords = $category->keywords;

$this->breadcrumbs = [
    'Блог' => $this->createUrl('/blog/default/index'),
];
$this->breadcrumbs = array_merge($this->breadcrumbs, $category->getBreadcrumbs());

if ($this->is(Access::ROLE_CONTROL)) {
    if ($this->moduleAllowed('blog')) {
        $this->admin[] = ['label' => 'Записи', 'url' => $this->createUrl('/blog/postAdmin')];
    }
    if ($this->moduleAllowed('blog')) {
        $this->admin[] = ['label' => 'Добавить запись', 'url' => $this->createUrl('/blog/postAdmin/create', ['category' => $category->id])];
    }
    if ($this->moduleAllowed('blog')) {
        $this->admin[] = ['label' => 'Редактировать категорию', 'url' => $this->createUrl('/blog/categoryAdmin/update', ['id' => $category->id])];
    }
    $this->info = '<p>Записи по категории</p>';
}
?>

<h1><?php echo CHtml::encode($category->title); ?></h1>

<?php $this->renderPartial('_loop', ['dataProvider' => $dataProvider]); ?>
