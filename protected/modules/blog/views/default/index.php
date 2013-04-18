<?php
/* @var $this DController */
/* @var $page Page */
/* @var $dataProvider CActiveDataProvider */

$this->pageTitle = $page->pagetitle . DNumberHelper::pageString($dataProvider->getPagination()->pageVar);
$this->description = $page->description . DNumberHelper::pageString($dataProvider->getPagination()->pageVar);
$this->keywords = $page->keywords;

$this->breadcrumbs=array(
    'Блог',
);

if ($this->is(Access::ROLE_CONTROL))
{
    if ($this->moduleAllowed('blog')) $this->admin[] = array('label'=>'Записи', 'url'=>$this->createUrl('/blog/postAdmin'));
    if ($this->moduleAllowed('blog')) $this->admin[] = array('label'=>'Добавить запись', 'url'=>$this->createUrl('/blog/postAdmin/create'));
    if ($this->moduleAllowed('blog')) $this->admin[] = array('label'=>'Категории', 'url'=>$this->createUrl('/blog/categoryAdmin'));
    if ($this->moduleAllowed('blog') && $page->id) $this->admin[] = array('label'=>'Редактировать страницу', 'url'=>$this->createUrl('/page/pageAdmin/update', array('id'=>$page->id)));
    if ($this->moduleAllowed('blog') && Yii::app()->moduleManager->active('comment') && $this->moduleAllowed('comment')) $this->admin = array_merge($this->admin, Yii::app()->moduleManager->notifications($this->module->id));

    $this->info = 'Здесь собраны записи из всех разделов';
}
?>

<h1><?php echo CHtml::encode($page->title); ?></h1>

<?php if (Yii::app()->request->getParam('page', 1) > 1): ?><noindex><?php endif; ?>
    <?php echo $this->decodeWidgets(trim($page->text_purified)); ?>
<?php if (Yii::app()->request->getParam('page', 1) > 1): ?></noindex><?php endif; ?>

<?php $this->renderPartial('_loop', array('dataProvider'=>$dataProvider)); ?>