<?php
$this->pageTitle='Новости';
$this->breadcrumbs=array(
    'Панель управления'=>array('/admin'),
    'Страницы'=>array('/page/pageAdmin/index'),
    'Шаблоны'=>array('index'),
    $model->title
);

$this->admin[] = array('label'=>'Редактировать', 'url'=>$this->createUrl('update', array('id'=>$this->id)));
if ($this->moduleAllowed('page')) $this->admin[] = array('label'=>'Страницы', 'url'=>$this->createUrl('/page/pageAdmin/index'));
$this->admin[] = array('label'=>'Добавить шаблон', 'url'=>$this->createUrl('create'));

$this->info = 'Шаблоны';
?>

<?php $this->layout = '//layouts/page/' . $model->alias; ?>

<h1><?php echo CHtml::encode($model->title); ?></h1>