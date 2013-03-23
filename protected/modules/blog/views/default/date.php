<?php
/* @var $this DController */
/* @var $date DDateLimiter */
/* @var $dataProvider CActiveDataProvider */

$this->pageTitle = 'Записи за ' . $date->date . DNumberHelper::pageString($dataProvider->getPagination()->pageVar);
$this->description = '';
$this->keywords = '';


$this->breadcrumbs=array(
    'Блог' => $this->createUrl('/blog/default/index'),
    'Записи от ' . $date->date,
);

if ($this->is(Access::ROLE_CONTROL)){

    if ($this->moduleAllowed('blog')) $this->admin[] = array('label'=>'Редактировать записи', 'url'=>$this->createUrl('/blog/postAdmin'));
    if ($this->moduleAllowed('blog')) $this->admin[] = array('label'=>'Добавить запись', 'url'=> $this->createUrl('/blog/postadmin/create'));
    $this->info = 'Здесь собраны записи по дате';
}
?>

<h1>Записи от <?php echo $date->date; ?></h1>

<?php $this->renderPartial('_loop', array('dataProvider'=>$dataProvider)); ?>