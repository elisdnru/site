<?php
$this->pageTitle = $page->pagetitle . DNumberHelper::pageString($dataProvider->getPagination()->pageVar);
$this->description = $page->description . DNumberHelper::pageString($dataProvider->getPagination()->pageVar);
$this->keywords = $page->keywords;

$this->breadcrumbs=array(
    $page->title,
);

if ($this->is(Access::ROLE_CONTROL)){

    if ($this->moduleAllowed('personnel')) $this->admin[] = array('label'=>'Сотрудники', 'url'=>$this->createUrl('/personnel/employeeAdmin/index'));
    if ($this->moduleAllowed('personnel')) $this->admin[] = array('label'=>'Добавить сотрудника', 'url'=>$this->createUrl('/personnel/employeeAdmin/create'));
    if ($this->moduleAllowed('personnel')) $this->admin[] = array('label'=>'Категории', 'url'=>$this->createUrl('/personnel/categoryAdmin/index'));
    if ($this->moduleAllowed('page')) if ($page->id) $this->admin[] = array('label'=>'Редактировать страницу', 'url'=>$this->createUrl('/page/pageAdmin/update', array('id'=>$page->id)));

    $this->info = 'Здесь собраны сотрудники из всех разделов';
}
?>

<h1><?php echo CHtml::encode($page->title); ?></h1>

<?php if ($categories): ?>
    <div class="subpages">
        <ul>
        <?php foreach ($categories as $category): ?>
            <li><a href="<?php echo $category->url; ?>"><?php echo $category->title; ?></a></li>
        <?php endforeach; ?>
        </ul>
    <div class="clear"></div>
    </div>
<?php endif; ?>

<?php if (Yii::app()->request->getParam('page', 1) > 1): ?><noindex><?php endif; ?>
<?php echo $this->decodeWidgets(trim($page->text_purified)); ?>
<?php if (Yii::app()->request->getParam('page', 1) > 1): ?></noindex><?php endif; ?>

<?php $this->renderPartial('_loop', array('dataProvider'=>$dataProvider)); ?>
