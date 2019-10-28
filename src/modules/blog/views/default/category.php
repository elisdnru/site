<?php
use app\modules\blog\models\Category;
use app\components\helpers\NumberHelper;
use app\modules\page\models\Page;
use app\modules\user\models\Access;

/** @var $this \yii\web\View */
/** @var $page Page */
/** @var $category Category */
/** @var $dataProvider CActiveDataProvider */

$this->context->layout = 'index';

$this->title = $category->pagetitle . ' - ' . $page->pagetitle . NumberHelper::pageString($dataProvider->getPagination()->pageVar);

$this->registerMetaTag([
    'name' => 'description',
    'content' => $category->description . NumberHelper::pageString($dataProvider->getPagination()->pageVar)
]);

$this->params['breadcrumbs'] = [
    'Блог' => ['/blog/default/index'],
];
$this->params['breadcrumbs'] = array_merge($this->params['breadcrumbs'], $category->getBreadcrumbs());

if (Yii::$app->user->can(Access::CONTROL)) {
    if (Yii::$app->moduleManager->allowed('blog')) {
        $this->params['admin'][] = ['label' => 'Записи', 'url' => ['/blog/admin/post']];
        $this->params['admin'][] = ['label' => 'Добавить запись', 'url' => ['/blog/admin/post/create', 'category' => $category->id]];
        $this->params['admin'][] = ['label' => 'Редактировать категорию', 'url' => ['/blog/admin/category/update', 'id' => $category->id]];
    }
}
?>

<h1><?= CHtml::encode($category->title) ?></h1>

<?= $this->render('_loop', ['dataProvider' => $dataProvider]); ?>
