<?php
/* @var $this DController */
/* @var $dataProvider CActiveDataProvider */

$this->pageTitle = 'Поиск по сайту' . DNumberHelper::pageString($dataProvider->getPagination()->pageVar);
$this->description = 'Поиск по сайту' . DNumberHelper::pageString($dataProvider->getPagination()->pageVar);
$this->keywords = '';

$this->breadcrumbs=array(
    'Поиск по сайту',
);

if ($this->is(Access::ROLE_CONTROL))
{
    if ($this->moduleAllowed('blog')) $this->admin[] = array('label'=>'Записи', 'url'=>$this->createUrl('/blog/postAdmin'));
    if ($this->moduleAllowed('page')) $this->admin[] = array('label'=>'Страницы', 'url'=>$this->createUrl('/page/pageAdmin'));
    if ($this->moduleAllowed('new')) $this->admin[] = array('label'=>'Новости', 'url'=>$this->createUrl('/new/newAdmin'));
    $this->info = 'Здесь собраны материалы из всех разделов';
}
?>

<h1>Поиск по сайту</h1>

<?php $this->widget('application.modules.search.widgets.SearchFormWidget'); ?>

<?php $this->renderPartial('_loop', array(
    'dataProvider'=>$dataProvider,
    'query'=>$query,
)); ?>