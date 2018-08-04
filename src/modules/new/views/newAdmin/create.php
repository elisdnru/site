<?php
$this->pageTitle='Редактор материала';
$this->breadcrumbs=array(
	'Панель управления'=>array('/admin'),
	'Новости'=>array('index'),
	'Редактор',
);

$this->admin[] = array('label'=>'Новости', 'url'=>$this->createUrl('index'));
if ($this->moduleAllowed('newsgallery')) if ($model->id) $this->admin[] = array('label'=>'Галереи', 'url'=>$this->createUrl('/newsgallery/galleryAdmin/index'));

$this->info = 'В поле «Раздел» перечислены страницы с типом «Новости/Статьи»';
?>

<h1>Добавление новости</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>
