<?php
$this->pageTitle = 'Галерея - ' . $category->pagetitle . DNumberHelper::pageString($dataProvider->getPagination()->pageVar);
$this->description = $category->description . $category->pagetitle . DNumberHelper::pageString($dataProvider->getPagination()->pageVar);
$this->keywords = $category->keywords;

$this->breadcrumbs = [
    $page->title => $this->createUrl('index'),
];
$this->breadcrumbs = array_merge($this->breadcrumbs, $category->breadcrumbs);

if ($this->is(Access::ROLE_CONTROL)) {
    if ($this->moduleAllowed('gallery')) {
        $this->admin[] = ['label' => 'Редактировать работы', 'url' => $this->createUrl('/gallery/photoAdmin/index', ['category' => $category->id])];
    }
    if ($this->moduleAllowed('gallery')) {
        $this->admin[] = ['label' => 'Добавить работу', 'url' => $this->createUrl('/gallery/photoAdmin/update', ['category' => $category->id])];
    }
    if ($this->moduleAllowed('gallery')) {
        $this->admin[] = ['label' => 'Категории', 'url' => $this->createUrl('/gallery/categoryAdmin/index')];
    }
    if ($this->moduleAllowed('gallery')) {
        $this->admin[] = ['label' => 'Редактировать категорию', 'url' => $this->createUrl('/gallery/categoryAdmin/update', ['id' => $category->id])];
    }

    $this->info = 'Работы категории';
}
?>

    <h1><a href="<?php echo $this->createUrl('index'); ?>">Галерея</a> &rarr;
        <?php foreach ($category->breadcrumbs as $title => $url) : ?>
            <?php if (!is_numeric($title)) : ?>
                <a href="<?php echo $url; ?>"><?php echo CHtml::encode($title); ?></a> &rarr;
            <?php endif; ?>
        <?php endforeach; ?>
        <?php echo CHtml::encode($category->title); ?>
    </h1>

    <div class="subpages">
        <ul>
            <li class="return">
                <a rel="nofollow" href="<?php echo $category->parent ? $category->parent->url : $this->createUrl('/gallery/default/index'); ?>">&larr;
                    Выше</a></li>
            <?php foreach ($subcategories as $subcategory) : ?>
                <li><a href="<?php echo $subcategory->url; ?>"><?php echo $subcategory->title; ?></a></li>
            <?php endforeach; ?>
        </ul>
        <div class="clear"></div>
    </div>

<?php if (Yii::app()->request->getParam('page', 1) > 1) :
    ?><noindex><?php
endif; ?>
<?php echo $this->decodeWidgets(trim($category->text)); ?>
<?php if (Yii::app()->request->getParam('page', 1) > 1) :
    ?></noindex><?php
endif; ?>

<?php $this->renderPartial('_loop', ['dataProvider' => $dataProvider]); ?>