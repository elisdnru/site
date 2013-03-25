<?php
/* @var $this DController */
/* @var $page Page */
/* @var $recipes Recipe[] */

$this->pageTitle = $page->pagetitle;
$this->description = $page->description;
$this->keywords = $page->keywords;

$this->breadcrumbs=array(
    $page->title,
);

if ($this->is(Access::ROLE_CONTROL)){

    if ($this->moduleAllowed('recipe')) $this->admin[] = array('label'=>'Рецепты', 'url'=>$this->createUrl('/recipe/recipeAdmin/index'));
    if ($this->moduleAllowed('recipe')) $this->admin[] = array('label'=>'Добавить рецепт', 'url'=>$this->createUrl('/recipe/recipeAdmin/create'));
    if ($this->moduleAllowed('page')) if ($page->id) $this->admin[] = array('label'=>'Редактировать страницу', 'url'=>$this->createUrl('/page/pageAdmin/update', array('id'=>$page->id)));

    $this->info = 'Рецепты';
} ?>

<h1><?php echo CHtml::encode($page->title); ?></h1>

<?php if (Yii::app()->request->getParam('page', 1) > 1): ?><noindex><?php endif; ?>
    <p><?php echo $this->decodeWidgets(trim($page->text_purified)); ?></p>
<?php if (Yii::app()->request->getParam('page', 1) > 1): ?></noindex><?php endif; ?>

<?php $this->renderPartial('_loop', array('recipes'=>$recipes)); ?>

<?php $this->widget('CLinkPager', array(
    'pages' => $pages,
)); ?>