<?php
$this->pageTitle = $rubric->title;
$this->description = $rubric->description;
$this->keywords = $rubric->keywords;

$this->breadcrumbs=array(
    $page->title => $this->createUrl('/shop/default/index'),
);

if ($type || $category)
{
    $this->breadcrumbs = array_merge($this->breadcrumbs, array(
        $rubric->title => $rubric->url,
    ));

    if ($type)
        $this->breadcrumbs = array_merge($this->breadcrumbs, array(
            $type->title => $type->url,
        ));

    if ($category)
        $this->breadcrumbs = array_merge($this->breadcrumbs, $category->getBreadcrumbs(true));
}
else
{
    $this->breadcrumbs[] = $rubric->title;
}

if ($this->is(Access::ROLE_CONTROL)){

    if ($this->moduleAllowed('shop')) $this->admin[] = array('label'=>'Товары', 'url'=>$this->createUrl('/shop/productAdmin/index'));
    if ($this->moduleAllowed('shop')) $this->admin[] = array('label'=>'Рубрики', 'url'=>$this->createUrl('/rubricator/rubricAdmin/index'));
    if ($this->moduleAllowed('shop')) $this->admin[] = array('label'=>'Редактировать рцбрику', 'url'=>$this->createUrl('/rubricator/rubricAdmin/update', array('id'=>$rubric->id)));
    if ($this->moduleAllowed('shop')) $this->admin[] = $this->admin = array_merge($this->admin, Yii::app()->moduleManager->notifications($this->module->id));
    if ($this->moduleAllowed('shop')) $this->admin[] = array('label'=>'Добавить товар', 'url'=>$this->createUrl('/shop/productAdmin/create'));

    $this->info = 'Товары рубрики';
}
?>

<?php $this->widget('colorbox.widgets.ColorboxWidget'); ?>

<h1>Товары рубрики &laquo;<?php echo CHtml::encode($rubric->title); ?>&raquo;</h1>

<?php $this->renderPartial('_loop', array('dataProvider'=>$dataProvider)); ?>