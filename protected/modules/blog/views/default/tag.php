<?php
/* @var $this DController */
/* @var $tag BlogTag */
/* @var $dataProvider CActiveDataProvider */

$this->pageTitle = 'Записи с меткой ' . $tag->title . DNumberHelper::pageString($dataProvider->getPagination()->pageVar);
$this->description = 'Записи с меткой ' . $tag->title . DNumberHelper::pageString($dataProvider->getPagination()->pageVar);
$this->keywords = $tag->title;


$this->breadcrumbs=array(
    'Блог' => $this->createUrl('/blog/default/index'),
    'Записи с меткой «' . $tag->title . '»',
);

if ($this->is(Access::ROLE_CONTROL)){

    if ($this->moduleAllowed('blog')) $this->admin[] = array('label'=>'Редактировать записи', 'url'=>$this->createUrl('/blog/postAdmin'));
    if ($this->moduleAllowed('blog')) $this->admin[] = array('label'=>'Добавить запись', 'url'=> $this->createUrl('/blog/postadmin/create'));
    $this->info = 'Здесь собраны записи по метке из всех разделов';
}
?>

<h1>Записи с меткой &laquo;<?php echo CHtml::encode($tag->title); ?>&raquo;</h1>

<?php $this->renderPartial('_loop', array('dataProvider'=>$dataProvider)); ?>