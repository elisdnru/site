<?php
/* @var $this DController */
/* @var $page Page */
/* @var $dataProvider CActiveDataProvider */

$this->pageTitle = $page->pagetitle;
$this->description = $page->description;
$this->keywords = $page->keywords;

$this->breadcrumbs=array(
    $page->title,
);

if ($this->is(Access::ROLE_CONTROL)){

    if ($this->moduleAllowed('rubrikator')) $this->admin[] = array('label'=>'Категории', 'url'=>$this->createUrl('/rubrikator/categoryAdmin/index'));
    if ($this->moduleAllowed('rubrikator')) $this->admin[] = array('label'=>'Статьи', 'url'=>$this->createUrl('/rubrikator/articleAdmin/index'));
    if ($this->moduleAllowed('rubrikator')) $this->admin[] = array('label'=>'Добавить статью', 'url'=>$this->createUrl('/rubrikator/articleAdmin/create'));
    if ($this->moduleAllowed('page')) if ($page->id) $this->admin[] = array('label'=>'Редактировать страницу', 'url'=>$this->createUrl('/page/pageAdmin/update', array('id'=>$page->id)));

    $this->info = 'Рубрикатор';
} ?>

<!-- <h1><?php echo CHtml::encode($page->title); ?></h1> -->

<?php if (Yii::app()->request->getParam('page', 1) > 1): ?><noindex><?php endif; ?>
    <p><?php echo $this->decodeWidgets(trim($page->text_purified)); ?></p>
<?php if (Yii::app()->request->getParam('page', 1) > 1): ?></noindex><?php endif; ?>

<?php $this->renderPartial('_loop', array('dataProvider'=>$dataProvider)); ?>