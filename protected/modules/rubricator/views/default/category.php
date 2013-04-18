<?php
/* @var $this DController */
/* @var $page Page */
/* @var $dataProvider CActiveDataProvider */

$this->pageTitle = $page->pagetitle;
$this->description = $page->description;
$this->keywords = $page->keywords;

$this->breadcrumbs=array(
    $page->title=>array('index'),
    $category->title
);

if ($this->is(Access::ROLE_CONTROL)){

    if ($this->moduleAllowed('rubricator')) $this->admin[] = array('label'=>'Категории', 'url'=>$this->createUrl('/rubricator/categoryAdmin/index'));
    if ($this->moduleAllowed('rubricator')) $this->admin[] = array('label'=>'Редактировать категорию', 'url'=>$this->createUrl('/rubricator/categoryAdmin/update', array('id'=>$category->id)));
    if ($this->moduleAllowed('rubricator')) $this->admin[] = array('label'=>'Статьи', 'url'=>$this->createUrl('/rubricator/articleAdmin/index'));
    if ($this->moduleAllowed('rubricator')) $this->admin[] = array('label'=>'Добавить статью', 'url'=>$this->createUrl('/rubricator/articleAdmin/create'));
    if ($this->moduleAllowed('page')) if ($page->id) $this->admin[] = array('label'=>'Редактировать страницу', 'url'=>$this->createUrl('/page/pageAdmin/update', array('id'=>$page->id)));

    $this->info = 'Рубрикатор';
} ?>

<!-- <h1><?php echo CHtml::encode($category->title); ?></h1>  -->

<?php if (Yii::app()->request->getParam('page', 1) > 1): ?><noindex><?php endif; ?>
    <?php echo $this->decodeWidgets(trim($category->text)); ?>
<?php if (Yii::app()->request->getParam('page', 1) > 1): ?></noindex><?php endif; ?>

<?php $this->renderPartial('_loop', array('dataProvider'=>$dataProvider)); ?>