<?php declare(strict_types=1);

use app\components\DataProvider;
use app\components\InlineWidgetsBehavior;
use app\components\PaginationFormatter;
use app\modules\blog\models\Category;
use app\modules\user\models\Access;
use yii\helpers\Html;
use yii\web\View;

/**
 * @var InlineWidgetsBehavior|View $this
 * @psalm-var View&InlineWidgetsBehavior $this
 * @var Category $category
 * @var DataProvider<Category> $dataProvider
 */
$this->context->layout = 'index';

$this->title = $category->meta_title . PaginationFormatter::appendix($dataProvider->getPagination()->getPage() + 1);

$this->registerMetaTag([
    'name' => 'description',
    'content' => $category->meta_description . PaginationFormatter::appendix($dataProvider->getPagination()->getPage() + 1),
]);

$this->params['breadcrumbs'] = [
    'Блог' => ['/blog/default/index'],
];
$this->params['breadcrumbs'] = array_merge($this->params['breadcrumbs'], $category->getBreadcrumbs());

if (Yii::$app->user->can(Access::CONTROL)) {
    if (Yii::$app->moduleAdminAccess->isGranted('blog')) {
        $this->params['admin'][] = ['label' => 'Записи', 'url' => ['/blog/admin/post']];
        $this->params['admin'][] = ['label' => 'Добавить запись', 'url' => ['/blog/admin/post/create', 'category' => $category->id]];
        $this->params['admin'][] = ['label' => 'Редактировать категорию', 'url' => ['/blog/admin/category/update', 'id' => $category->id]];
    }
}
?>

<h1><?= Html::encode($category->title); ?></h1>

<?php if (Yii::$app->request->get('page', 1) > 1) : ?>
    <!--noindex-->
<?php endif; ?>
<?= $this->decodeWidgets(trim($category->text)); ?>
<?php if (Yii::$app->request->get('page', 1) > 1) : ?>
    <!--/noindex-->
<?php endif; ?>

<?= $this->render('_loop', ['dataProvider' => $dataProvider]); ?>
