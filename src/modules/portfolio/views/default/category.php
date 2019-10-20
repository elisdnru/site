<?php

use app\components\helpers\NumberHelper;
use app\modules\user\models\Access;

/** @var $dataProvider CDataProvider */
/** @var $category \app\modules\portfolio\models\Category */
/** @var $subcategories \app\modules\portfolio\models\Category[] */
/** @var $page \app\modules\page\models\Page */
$this->layout = '/layouts/index';

$this->title = 'Портфолио - ' . $category->pagetitle . NumberHelper::pageString($dataProvider->getPagination()->pageVar);
$this->description = $category->description . $category->pagetitle . NumberHelper::pageString($dataProvider->getPagination()->pageVar);

$this->params['breadcrumbs'] = [
    $page->title => $this->createUrl('index'),
];
$this->params['breadcrumbs'] = array_merge($this->params['breadcrumbs'], $category->breadcrumbs);

if (Yii::app()->user->checkAccess(Access::ROLE_CONTROL)) {
    if (Yii::app()->moduleManager->allowed('portfolio')) {
        $this->admin[] = ['label' => 'Редактировать работы', 'url' => $this->createUrl('/portfolio/admin/work/index', ['category' => $category->id])];
        $this->admin[] = ['label' => 'Добавить работу', 'url' => $this->createUrl('/portfolio/admin/work/update', ['category' => $category->id])];
        $this->admin[] = ['label' => 'Категории', 'url' => $this->createUrl('/portfolio/admin/category/index')];
        $this->admin[] = ['label' => 'Редактировать категорию', 'url' => $this->createUrl('/portfolio/admin/category/update', ['id' => $category->id])];
    }
}
?>

<h1><a rel="nofollow" href="<?php echo $this->createUrl('index'); ?>">Портфолио</a> &rarr;
    <?php foreach ($category->breadcrumbs as $title => $url) : ?>
        <?php if (!is_numeric($title)) : ?>
            <a rel="nofollow" href="<?php echo $url; ?>"><?php echo CHtml::encode($title); ?></a> &rarr;
        <?php endif; ?>
    <?php endforeach; ?>
    <?php echo CHtml::encode($category->title); ?>
</h1>

<div class="subpages">
    <ul>
        <li class="return">
            <a rel="nofollow" href="<?php echo $category->parent ? $category->parent->url : $this->createUrl('/portfolio/default/index'); ?>">&larr;
                Выше</a></li>
        <?php foreach ($subcategories as $subcategory) : ?>
            <li><a rel="nofollow" href="<?php echo $subcategory->url; ?>"><?php echo $subcategory->title; ?></a>
            </li>
        <?php endforeach; ?>
    </ul>
    <div class="clear"></div>
</div>

<?php if (Yii::app()->request->getParam('page', 1) > 1) :
?>
<noindex><?php
    endif; ?>
    <?php echo $this->decodeWidgets(trim($category->text)); ?>
    <?php if (Yii::app()->request->getParam('page', 1) > 1) :
    ?></noindex><?php
endif; ?>

<?php $this->renderPartial('_loop', ['dataProvider' => $dataProvider]); ?>
