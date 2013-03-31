<?php
$this->pageTitle='Редактор товара';
$this->breadcrumbs=array(
	'Панель управления'=>array('/admin'),
	'Товары'=>array('index'),
    $clone ? 'Копирование товара' : 'Добавление товара'
);

$this->admin[] = array('label'=>'Товары', 'url'=>$this->createUrl('index'));
$this->info = 'Редактирование товара';
?>

<?php if ($clone): ?>
<h1>Копирование товара</h1>
<?php else: ?>
<h1>Добавление товара</h1>
<?php endif; ?>

<?php $this->renderPartial('_form', array('model'=>$model, 'clone'=>$clone)); ?>

