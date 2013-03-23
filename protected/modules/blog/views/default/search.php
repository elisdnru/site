<?php
/* @var $this DController */
/* @var $searchForm BlogSearchForm */
/* @var $dataProvider CActiveDataProvider */

$this->pageTitle = 'Поиск по записям' . DNumberHelper::pageString($dataProvider->getPagination()->pageVar);
$this->description = '' ;
$this->keywords = '';


$this->breadcrumbs=array(
    'Блог' => $this->createUrl('/blog/default/index'),
    'Поиск',
);

if ($this->is(Access::ROLE_CONTROL)){

    if ($this->moduleAllowed('blog')) $this->admin[] = array('label'=>'Редактировать записи', 'url'=>$this->createUrl('/blog/postAdmin'));
    if ($this->moduleAllowed('blog')) $this->admin[] = array('label'=>'Добавить запись', 'url'=> $this->createUrl('/blog/postadmin/create'));
    $this->info = 'Здесь собраны записи по метке из всех разделов';
}
?>

<h1>Поиск по блогу</h1>

<?php $this->widget('blog.widgets.BlogSearchFormWidget'); ?>

<?php $this->renderPartial('_loop', array('dataProvider'=>$dataProvider)); ?>