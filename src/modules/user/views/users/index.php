<?php
$this->pageTitle='Пользователи';
$this->breadcrumbs=array(
    'Пользователи',
);

if ($this->is(Access::ROLE_CONTROL))
{
    $this->admin[] = array('label'=>'Пользователи', 'url'=>$this->createUrl('/user/userAdmin/index'));

    $this->info = 'Управлять пользователями Вы можете в панели управления';
}

?>

<?php $this->beginWidget('DPortlet', array('title' => 'Пользователи'));?>

<?php $this->renderPartial('_loop', array('dataProvider'=>$dataProvider)); ?>

<?php $this->endWidget(); ?>

