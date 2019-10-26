<?php

use app\components\helpers\NumberHelper;
use app\modules\page\models\Page;
use app\modules\portfolio\models\Category;
use app\modules\user\models\Access;

/** @var $dataProvider CDataProvider */
/** @var $page Page */
/** @var $categories Category[] */
$this->layout = '/layouts/index';

$this->title = $page->pagetitle;

$this->registerMetaTag([
    'name' => 'description',
    'content' => $page->description,
]);

$this->params['breadcrumbs'] = [
    $page->title,
];

if (Yii::app()->user->checkAccess(Access::CONTROL)) {
    if (Yii::$app->moduleManager->allowed('portfolio')) {
        $this->params['admin'][] = ['label' => 'Работы', 'url' => $this->createUrl('/portfolio/admin/work/index')];
        $this->params['admin'][] = ['label' => 'Добавить работу', 'url' => $this->createUrl('/portfolio/admin/work/create')];
        $this->params['admin'][] = ['label' => 'Категории', 'url' => $this->createUrl('/portfolio/admin/category/index')];
    }
    if (Yii::$app->moduleManager->allowed('page')) {
        if ($page->id) {
            $this->params['admin'][] = ['label' => 'Редактировать страницу', 'url' => $this->createUrl('/page/admin/page/update', ['id' => $page->id])];
        }
    }
}
?>

<h1><?= CHtml::encode($page->title) ?></h1>

<?php if ($categories) : ?>
    <div class="subpages">
        <ul>
            <?php foreach ($categories as $category) : ?>
                <li><a rel="nofollow" href="<?= $category->url ?>"><?= $category->title ?></a></li>
            <?php endforeach; ?>
        </ul>
        <div class="clear"></div>
    </div>
<?php endif; ?>

<?php if (Yii::app()->request->getParam('page', 1) > 1): ?><!--noindex--><?php endif; ?>
<?= $this->decodeWidgets(trim($page->text_purified)) ?>
<?php if (Yii::app()->request->getParam('page', 1) > 1): ?><!--/noindex--><?php endif; ?>

<?= $this->renderPartial('_loop', ['dataProvider' => $dataProvider]); ?>
