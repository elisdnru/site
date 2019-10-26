<?php

use app\components\helpers\NumberHelper;
use app\modules\page\models\Page;
use app\modules\portfolio\models\Category;
use app\modules\user\models\Access;
use yii\helpers\Url;

/** @var $dataProvider CDataProvider */
/** @var $category Category */
/** @var $subcategories Category[] */
/** @var $page Page */
$this->context->layout = 'index';

$this->title = 'Портфолио - ' . $category->pagetitle . NumberHelper::pageString($dataProvider->getPagination()->pageParam);

$this->registerMetaTag([
    'name' => 'description',
    'content' => $category->description . NumberHelper::pageString($dataProvider->getPagination()->pageParam),
]);

$this->params['breadcrumbs'] = [
    $page->title => ['index'],
];
$this->params['breadcrumbs'] = array_merge($this->params['breadcrumbs'], $category->breadcrumbs);

if (Yii::app()->user->checkAccess(Access::CONTROL)) {
    if (Yii::$app->moduleManager->allowed('portfolio')) {
        $this->params['admin'][] = ['label' => 'Редактировать работы', 'url' => ['/portfolio/admin/work/index', 'category' => $category->id]];
        $this->params['admin'][] = ['label' => 'Добавить работу', 'url' => ['/portfolio/admin/work/update', 'category' => $category->id]];
        $this->params['admin'][] = ['label' => 'Категории', 'url' => ['/portfolio/admin/category/index']];
        $this->params['admin'][] = ['label' => 'Редактировать категорию', 'url' => ['/portfolio/admin/category/update', 'id' => $category->id]];
    }
}
?>

<h1><a rel="nofollow" href="<?= Url::to(['index']) ?>">Портфолио</a> &rarr;
    <?php foreach ($category->breadcrumbs as $title => $url) : ?>
        <?php if (!is_numeric($title)) : ?>
            <a rel="nofollow" href="<?= $url ?>"><?= CHtml::encode($title) ?></a> &rarr;
        <?php endif; ?>
    <?php endforeach; ?>
    <?= CHtml::encode($category->title) ?>
</h1>

<div class="subpages">
    <ul>
        <li class="return">
            <a rel="nofollow" href="<?= $category->parent ? $category->parent->url : Url::to(['/portfolio/default/index']) ?>">&larr;
                Выше</a></li>
        <?php foreach ($subcategories as $subcategory) : ?>
            <li><a rel="nofollow" href="<?= $subcategory->url ?>"><?= $subcategory->title ?></a>
            </li>
        <?php endforeach; ?>
    </ul>
    <div class="clear"></div>
</div>

<?php if (Yii::app()->request->getParam('page', 1) > 1) : ?>
    <!--noindex-->
<?php endif; ?>
<?= $this->decodeWidgets(trim($category->text)) ?>
<?php if (Yii::app()->request->getParam('page', 1) > 1) : ?>
    <!--/noindex-->
<?php endif; ?>

<?= $this->render('_loop', ['dataProvider' => $dataProvider]); ?>
