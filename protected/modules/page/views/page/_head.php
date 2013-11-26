<?php
/** @var $page Page */

$this->pageTitle = $page->pagetitle ? $page->pagetitle : $page->title;
$this->description = $page->description;
$this->keywords = $page->keywords;

$this->breadcrumbs = $page->alias != 'index' ? $page->breadcrumbs : array();

Yii::app()->clientScript->registerMetaTag($page->robots, 'robots');

if ($this->is(Access::ROLE_CONTROL)){

    if ($this->moduleAllowed('page')) $this->admin[] = array('label'=>'Редактировать', 'url'=>$this->createUrl('/page/pageAdmin/update', array('id'=>$page->id)));
    if ($this->moduleAllowed('page')) $this->admin[] = array('label'=>'Cтраницы', 'url'=>$this->createUrl('/page/pageAdmin/index'));
    if ($this->moduleAllowed('page')) $this->admin[] = array('label'=>'Подстраницы', 'url'=>$this->createUrl('/page/pageAdmin/index', array('Page[parent_id]'=>$page->id)));

    $this->info = 'Страница';
}
?>

<?php $this->widget('colorbox.widgets.ColorboxWidget'); ?>