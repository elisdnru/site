<?php
$this->pageTitle='Редактор материала';
$this->breadcrumbs=array(
	'Панель управления'=>array('/admin'),
	'Новости'=>array('index'),
	'Редактор',
);

if ($model->url) $this->admin[] = array('label'=>'Просмотр', 'url'=>$model->url);
$this->admin[] = array('label'=>'Новости', 'url'=>$this->createUrl('index'));
if ($this->moduleAllowed('gallery')) if ($model->id) $this->admin[] = array('label'=>'Галереи', 'url'=>$this->createUrl('/gallery/galleryAdmin/index'));
if ($model->id && $model->page) $this->admin[] = array('label'=>'Просмотр страницы', 'url'=>$model->page->url);
if ($this->moduleAllowed('page')) if ($model->page_id) $this->admin[] = array('label'=>'Править страницу', 'url'=>$this->createUrl('', array('id'=>$model->page_id)));

$this->info = 'В поле «Раздел» перечислены страницы с типом «Новости/Статьи»';
?>

<h1>Редактирование новости</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>
