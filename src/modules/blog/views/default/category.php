<?php

use app\components\InlineWidgetsBehavior;
use app\modules\blog\models\Category;
use app\components\PaginationFormatter;
use app\modules\user\models\Access;
use yii\data\ActiveDataProvider;
use yii\helpers\Html;
use yii\web\View;

/**
 * @var View|InlineWidgetsBehavior $this
 * @var Category $category
 * @var ActiveDataProvider $dataProvider
 */

$this->context->layout = 'index';

$this->title = $category->pagetitle . PaginationFormatter::appendix($dataProvider->getPagination()->getPage() + 1);

$this->registerMetaTag([
    'name' => 'description',
    'content' => $category->description . PaginationFormatter::appendix($dataProvider->getPagination()->getPage() + 1)
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

<h1><?= Html::encode($category->title) ?></h1>

<?php if (Yii::$app->request->get('page', 1) > 1) : ?>
    <!--noindex-->
<?php endif; ?>
<?= $this->decodeWidgets(trim($category->text)) ?>
<?php if (Yii::$app->request->get('page', 1) > 1) : ?>
    <!--/noindex-->
<?php endif; ?>

<?= $this->render('_loop', ['dataProvider' => $dataProvider]) ?>
