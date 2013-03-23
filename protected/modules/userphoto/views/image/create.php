<?php
$this->pageTitle='Редактор фотографии';
$this->breadcrumbs=array(
	'Добавление фотографии'
);
?>

<h1>Добавление фотографии</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>

