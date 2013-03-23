<?php
/* @var $this DController */
/* @var $page Page */
/* @var $recipe Recipe */

$this->pageTitle = $page->pagetitle;
$this->description = $page->description;
$this->keywords = $page->keywords;

$this->breadcrumbs=array(
    $page->title,
);

if ($this->is(Access::ROLE_CONTROL)){

    if ($this->moduleAllowed('review')) $this->admin[] = array('label'=>'Отзывы', 'url'=>$this->createUrl('/review/reviewAdmin/index'));
    if ($this->moduleAllowed('review')) $this->admin[] = array('label'=>'Добавить отзыв', 'url'=>$this->createUrl('/review/reviewAdmin/update'));
    if ($this->moduleAllowed('page')) if ($page->id) $this->admin[] = array('label'=>'Редактировать страницу', 'url'=>$this->createUrl('/page/pageAdmin/update', array('id'=>$page->id)));

    $this->info = 'Отзывы';
}
?>

<h1><?php echo CHtml::encode($page->title); ?></h1>



<?php if (Yii::app()->request->getParam('page', 1) > 1): ?><noindex><?php endif; ?>
    <p><?php echo $this->processWidgets(trim($page->text_purified)); ?></p>
<?php if (Yii::app()->request->getParam('page', 1) > 1): ?></noindex><?php endif; ?>

<?php $this->renderPartial('_loop', array('reviews'=>$reviews)); ?>

<?php $this->widget('DLinkPager', array(
    'pages' => $pages,
)); ?>

<?php $this->renderPartial('_form', array('reviewForm'=>$reviewForm)); ?>