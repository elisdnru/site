<?php declare(strict_types=1);

use app\assets\PortfolioAsset;
use app\components\DataProvider;
use app\components\PaginationFormatter;
use app\components\shortcodes\Shortcodes;
use app\modules\portfolio\models\Category;
use app\modules\portfolio\models\Work;
use app\modules\user\models\Access;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;

/**
 * @var View $this
 * @var DataProvider<Work> $dataProvider
 * @var Category $category
 * @var Category[] $subcategories
 */
$this->context->layout = 'index';

$this->title = $category->meta_title . PaginationFormatter::appendix($dataProvider->getPagination()->getPage() + 1);

$this->registerMetaTag([
    'name' => 'description',
    'content' => $category->meta_description . PaginationFormatter::appendix($dataProvider->getPagination()->getPage() + 1),
]);

$this->params['breadcrumbs'] = [
    'Портфолио' => ['index'],
];
$this->params['breadcrumbs'] = array_merge($this->params['breadcrumbs'], $category->getBreadcrumbs());

if (Yii::$app->user->can(Access::CONTROL)) {
    if (Yii::$app->moduleAdminAccess->isGranted('portfolio')) {
        $this->params['admin'][] = ['label' => 'Редактировать работы', 'url' => ['/portfolio/admin/work/index', 'category' => $category->id]];
        $this->params['admin'][] = ['label' => 'Добавить работу', 'url' => ['/portfolio/admin/work/update', 'category' => $category->id]];
        $this->params['admin'][] = ['label' => 'Категории', 'url' => ['/portfolio/admin/category/index']];
        $this->params['admin'][] = ['label' => 'Редактировать категорию', 'url' => ['/portfolio/admin/category/update', 'id' => $category->id]];
    }
}

PortfolioAsset::register($this);
?>

<h1><a rel="nofollow" href="<?= Url::to(['index']); ?>">Портфолио</a> &rarr;
    <?php foreach ($category->getBreadcrumbs() as $title => $url) : ?>
        <?php if (!is_numeric($title)) : ?>
            <a rel="nofollow" href="<?= $url; ?>"><?= Html::encode($title); ?></a> &rarr;
        <?php endif; ?>
    <?php endforeach; ?>
    <?= Html::encode($category->title); ?>
</h1>

<?php if ($subcategories) : ?>
    <div class="subpages">
        <ul>
            <?php foreach ($subcategories as $subcategory) : ?>
                <li><a rel="nofollow" href="<?= $subcategory->getUrl(); ?>"><?= $subcategory->title; ?></a>
                </li>
            <?php endforeach; ?>
        </ul>
        <div class="clear"></div>
    </div>
<?php endif; ?>

<?php if (Yii::$app->request->get('page', 1) > 1) : ?>
    <!--noindex-->
<?php endif; ?>

<?php Shortcodes::begin(); ?>
<?= $category->text; ?>
<?php Shortcodes::end(); ?>

<?php if (Yii::$app->request->get('page', 1) > 1) : ?>
    <!--/noindex-->
<?php endif; ?>

<?= $this->render('_loop', ['dataProvider' => $dataProvider]); ?>
