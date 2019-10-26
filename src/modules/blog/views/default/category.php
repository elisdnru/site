<?php
/** @var $this Controller */

use app\modules\blog\models\Category;
use app\components\Controller;
use app\components\helpers\NumberHelper;
use app\modules\page\models\Page;
use app\modules\user\models\Access;

/** @var $page Page */
/** @var $category Category */
/** @var $dataProvider CActiveDataProvider */

$this->layout = '/layouts/index';

$this->title = $category->pagetitle . ' - ' . $page->pagetitle . NumberHelper::pageString($dataProvider->getPagination()->pageVar);

$this->registerMetaTag([
    'name' => 'description',
    'content' => $category->description . NumberHelper::pageString($dataProvider->getPagination()->pageVar)
]);

$this->params['breadcrumbs'] = [
    'Блог' => $this->createUrl('/blog/default/index'),
];
$this->params['breadcrumbs'] = array_merge($this->params['breadcrumbs'], $category->getBreadcrumbs());

if (Yii::app()->user->checkAccess(Access::CONTROL)) {
    if (Yii::$app->moduleManager->allowed('blog')) {
        $this->params['admin'][] = ['label' => 'Записи', 'url' => $this->createUrl('/blog/admin/post')];
        $this->params['admin'][] = ['label' => 'Добавить запись', 'url' => $this->createUrl('/blog/admin/post/create', ['category' => $category->id])];
        $this->params['admin'][] = ['label' => 'Редактировать категорию', 'url' => $this->createUrl('/blog/admin/category/update', ['id' => $category->id])];
    }
}
?>

<h1><?= CHtml::encode($category->title) ?></h1>

<?= $this->renderPartial('_loop', ['dataProvider' => $dataProvider]); ?>
