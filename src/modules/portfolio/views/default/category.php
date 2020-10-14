<?php

use app\components\PaginationFormatter;
use app\modules\page\models\Page;
use app\modules\portfolio\models\Category;
use app\modules\user\models\Access;
use yii\data\ActiveDataProvider;
use yii\helpers\Html;
use yii\helpers\Url;

/** @var $dataProvider ActiveDataProvider */
/** @var $category Category */
/** @var $subcategories Category[] */
$this->context->layout = 'index';

$this->title = $category->pagetitle . PaginationFormatter::appendix($dataProvider->getPagination()->getPage() + 1);

$this->registerMetaTag([
    'name' => 'description',
    'content' => $category->description . PaginationFormatter::appendix($dataProvider->getPagination()->getPage() + 1),
]);

$this->params['breadcrumbs'] = [
    'Портфолио' => ['index'],
];
$this->params['breadcrumbs'] = array_merge($this->params['breadcrumbs'], $category->breadcrumbs);

if (Yii::$app->user->can(Access::CONTROL)) {
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
            <a rel="nofollow" href="<?= $url ?>"><?= Html::encode($title) ?></a> &rarr;
        <?php endif; ?>
    <?php endforeach; ?>
    <?= Html::encode($category->title) ?>
</h1>

<?php if ($subcategories) : ?>
    <div class="subpages">
        <ul>
            <?php foreach ($subcategories as $subcategory) : ?>
                <li><a rel="nofollow" href="<?= $subcategory->getUrl() ?>"><?= $subcategory->title ?></a>
                </li>
            <?php endforeach; ?>
        </ul>
        <div class="clear"></div>
    </div>
<?php endif; ?>

<?php if (Yii::$app->request->get('page', 1) > 1) : ?>
    <!--noindex-->
<?php endif; ?>
<?= $this->decodeWidgets(trim($category->text)) ?>
<?php if (Yii::$app->request->get('page', 1) > 1) : ?>
    <!--/noindex-->
<?php endif; ?>

<?= $this->render('_loop', ['dataProvider' => $dataProvider]) ?>
