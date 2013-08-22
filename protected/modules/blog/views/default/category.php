<?php
/* @var $this DController */
/* @var $page Page */
/* @var $category BlogCategory */
/* @var $dataProvider CActiveDataProvider */

$this->pageTitle = $category->pagetitle . ' - ' . $page->pagetitle . DNumberHelper::pageString($dataProvider->getPagination()->pageVar);
$this->description = $category->description . DNumberHelper::pageString($dataProvider->getPagination()->pageVar);
$this->keywords = $category->keywords;

$this->breadcrumbs=array(
    'Блог' => $this->createUrl('/blog/default/index'),
);
$this->breadcrumbs = array_merge($this->breadcrumbs, $category->getBreadcrumbs());

if ($this->is(Access::ROLE_CONTROL))
{
    if ($this->moduleAllowed('blog')) $this->admin[] = array('label'=>'Записи', 'url'=>$this->createUrl('/blog/postAdmin'));
    if ($this->moduleAllowed('blog')) $this->admin[] = array('label'=>'Добавить запись', 'url'=>$this->createUrl('/blog/postAdmin/create', array('category'=>$category->id)));
    if ($this->moduleAllowed('blog')) $this->admin[] = array('label'=>'Редактировать категорию', 'url'=>$this->createUrl('/blog/postCategory/update', array('id'=>$category->id)));
    $this->info = '<p>Записи по категории</p>';
}
?>

<h1><?php echo CHtml::encode($category->title); ?></h1>

<?php $this->renderPartial('_loop', array('dataProvider'=>$dataProvider)); ?>