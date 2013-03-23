<?php
/* @var $this DAdminController */
/* @var $model Callme */

$this->pageTitle='Заказы звонков';
$this->breadcrumbs=array(
	'Панель управления'=>array('/admin'),
	'Заказы звонков',
);

if ($this->moduleAllowed('contact')) $this->admin[] = array('label'=>'Сообщения', 'url'=>$this->createUrl('/contact/contactAdmin/index'));
if ($this->moduleAllowed('comment')) $this->admin[] = array('label'=>'Комментарии', 'url'=>$this->createUrl('/comment/commentAdmin/index'));

$this->info = 'Отметка о прочтении выставляется автоматически';

?>

<h1>Заказы звонков</h1>

<?php $this->renderPartial('_grid', array('model'=>$model)); ?>

