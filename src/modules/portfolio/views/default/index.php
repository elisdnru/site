<?php

use app\components\helpers\NumberHelper;
use app\modules\user\models\Access;

/** @var $dataProvider CDataProvider */
/** @var $page \app\modules\page\models\Page */
/** @var $categories \app\modules\portfolio\models\Category[] */
$this->layout = '/layouts/index';

$this->title = $page->pagetitle . NumberHelper::pageString($dataProvider->getPagination()->pageVar);
$this->description = $page->description . NumberHelper::pageString($dataProvider->getPagination()->pageVar);

$this->params['breadcrumbs'] = [
    $page->title,
];

if (Yii::app()->user->checkAccess(Access::ROLE_CONTROL)) {
    if (Yii::app()->moduleManager->allowed('portfolio')) {
        $this->admin[] = ['label' => 'Работы', 'url' => $this->createUrl('/portfolio/admin/work/index')];
        $this->admin[] = ['label' => 'Добавить работу', 'url' => $this->createUrl('/portfolio/admin/work/create')];
        $this->admin[] = ['label' => 'Категории', 'url' => $this->createUrl('/portfolio/admin/category/index')];
    }
    if (Yii::app()->moduleManager->allowed('page')) {
        if ($page->id) {
            $this->admin[] = ['label' => 'Редактировать страницу', 'url' => $this->createUrl('/page/admin/page/update', ['id' => $page->id])];
        }
    }
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

<?php if (Yii::app()->request->getParam('page', 1) > 1): ?><!--noindex--><?php endif; ?>
<?php echo $this->decodeWidgets(trim($page->text_purified)); ?>
<?php if (Yii::app()->request->getParam('page', 1) > 1): ?><!--/noindex--><?php endif; ?>

<?php $this->renderPartial('_loop', ['dataProvider' => $dataProvider]); ?>
