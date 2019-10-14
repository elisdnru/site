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

$this->pageTitle = $category->pagetitle . ' - ' . $page->pagetitle . NumberHelper::pageString($dataProvider->getPagination()->pageVar);
$this->description = $category->description . NumberHelper::pageString($dataProvider->getPagination()->pageVar);
$this->keywords = $category->keywords;

$this->breadcrumbs = [
    'Блог' => $this->createUrl('/blog/default/index'),
];
$this->breadcrumbs = array_merge($this->breadcrumbs, $category->getBreadcrumbs());

if ($this->is(Access::ROLE_CONTROL)) {
    if ($this->moduleAllowed('blog')) {
        $this->admin[] = ['label' => 'Записи', 'url' => $this->createUrl('/blog/postAdmin')];
        $this->admin[] = ['label' => 'Добавить запись', 'url' => $this->createUrl('/blog/admin/post/create', ['category' => $category->id])];
        $this->admin[] = ['label' => 'Редактировать категорию', 'url' => $this->createUrl('/blog/admin/category/update', ['id' => $category->id])];
    }
}
?>

<h1><?php echo CHtml::encode($category->title); ?></h1>

<?php $this->renderPartial('_loop', ['dataProvider' => $dataProvider]); ?>
