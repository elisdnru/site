<?php
/* @var $this DController */

$username = Yii::app()->request->getQuery('username');

$this->pageTitle = 'Фоторграфии пользователя ' . $username;
$this->description = '';
$this->keywords = '';

$this->breadcrumbs=array(
    'Фоторграфии',
);

if ($this->is(Access::ROLE_CONTROL))
{
    if ($this->moduleAllowed('userphoto')) $this->admin[] = array('label'=>'Фотографии', 'url'=>$this->createUrl('/userphoto/photoAdmin/index'));

    $this->info = 'Фоторграфии пользователя';
} ?>

<h1>Фоторграфии пользователя <?php echo CHtml::encode($username); ?></h1>

<?php $this->renderPartial('_loop', array('dataProvider'=>$dataProvider)); ?>