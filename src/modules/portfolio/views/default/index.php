<?php

use app\modules\main\components\helpers\DNumberHelper;
use app\modules\user\models\Access;

$this->pageTitle = $page->pagetitle . DNumberHelper::pageString($dataProvider->getPagination()->pageVar);
$this->description = $page->description . DNumberHelper::pageString($dataProvider->getPagination()->pageVar);
$this->keywords = $page->keywords;

$this->breadcrumbs = [
    $page->title,
];

if ($this->is(Access::ROLE_CONTROL)) {
    if ($this->moduleAllowed('portfolio')) {
        $this->admin[] = ['label' => 'Работы', 'url' => $this->createUrl('/portfolio/workAdmin/index')];
    }
    if ($this->moduleAllowed('portfolio')) {
        $this->admin[] = ['label' => 'Добавить работу', 'url' => $this->createUrl('/portfolio/workAdmin/create')];
    }
    if ($this->moduleAllowed('portfolio')) {
        $this->admin[] = ['label' => 'Категории', 'url' => $this->createUrl('/portfolio/categoryAdmin/index')];
    }
    if ($this->moduleAllowed('page')) {
        if ($page->id) {
            $this->admin[] = ['label' => 'Редактировать страницу', 'url' => $this->createUrl('/page/pageAdmin/update', ['id' => $page->id])];
        }
    }

    $this->info = 'Здесь собраны работы из всех разделов';
}
?>

<h1><?php echo CHtml::encode($page->title); ?></h1>

<?php if ($categories) : ?>
    <div class="subpages">
        <ul>
            <?php foreach ($categories as $category) : ?>
                <li><a rel="nofollow" href="<?php echo $category->url; ?>"><?php echo $category->title; ?></a></li>
            <?php endforeach; ?>
        </ul>
        <div class="clear"></div>
    </div>
<?php endif; ?>

<?php if (Yii::app()->request->getParam('page', 1) > 1) : ?>
<?php endif; ?>
<?php echo $this->decodeWidgets(trim($page->text_purified)); ?>
<?php if (Yii::app()->request->getParam('page', 1) > 1) :
?></noindex><?php
endif; ?>

<?php $this->renderPartial('_loop', ['dataProvider' => $dataProvider]); ?>
