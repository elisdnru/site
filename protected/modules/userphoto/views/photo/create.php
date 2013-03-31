<?php
$this->pageTitle='Редактор фотографии';
$this->breadcrumbs=array(
	'Добавление фотографии'
);

if ($this->is(Access::ROLE_CONTROL)){

    if ($this->moduleAllowed('userphoto')) $this->admin[] = array('label'=>'Фотографии', 'url'=>$this->createUrl('/userphoto/photoAdmin/index'));
    if ($this->moduleAllowed('userphoto') && Yii::app()->moduleManager->active('comment') && $this->moduleAllowed('comment')) $this->admin = array_merge($this->admin, Yii::app()->moduleManager->notifications($this->module->id));

    $this->info = 'Фотографии пользователя';
}?>

<h1>Добавление фотографии</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>

