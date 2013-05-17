<?php
$this->pageTitle='Редактор книги';
$this->breadcrumbs=array(
    'Панель управления'=>array('/admin'),
    'Книги'=>array('index'),
    'Редактор',
);

$this->admin[] = array('label'=>'Редактировать', 'url'=>$this->createUrl('update', array('id'=>$model->id)));
$this->admin[] = array('label'=>'Книги', 'url'=>$this->createUrl('index'));
$this->admin[] = array('label'=>'Добавить книгу', 'url'=>$this->createUrl('create'));

$this->info = 'Книги';
?>

<h1><?php echo CHtml::encode($model->title); ?></h1>

<?php
$this->widget('zii.widgets.CDetailView', array(
    'data'=>$model,
    'tagName'=>'table',
    'itemTemplate'=>"<tr><th style=\"width:150px; text-align:left\">{label}</th><td>{value}</td></tr>\n",
    'htmlOptions'=>array('class'=>'detail-view nomargin'),
    'cssFile'=>false,
    'attributes'=>array(
        array(
            'label'=>'',
            'type'=>'html',
            'value'=>CHtml::image($model->imageUrl),
        ),
        'title',
        array(
            'label'=>'Превью',
            'type'=>'html',
            'value'=>$model->short_purified,
        ),
        'code',
        array(
            'label'=>'URL',
            'type'=>'html',
            'value'=>CHtml::link($model->alias, $model->originalUrl, array('target'=>'_blank')),
        ),
    ),
));
?>