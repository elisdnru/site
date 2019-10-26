<?php
/** @var $this \yii\web\View */

use app\components\helpers\NumberHelper;
use app\modules\page\models\Page;
use app\modules\user\models\Access;

/** @var $page Page */
/** @var $dataProvider CActiveDataProvider */

$this->context->layout = 'index';

$this->title = $page->pagetitle . NumberHelper::pageString($dataProvider->getPagination()->pageVar);

$this->registerMetaTag([
    'name' => 'description',
    'content' => $page->description . NumberHelper::pageString($dataProvider->getPagination()->pageVar)
]);

$this->params['breadcrumbs'] = [
    'Блог',
];

if (Yii::app()->user->checkAccess(Access::CONTROL)) {
    if (Yii::$app->moduleManager->allowed('blog')) {
        $this->params['admin'][] = ['label' => 'Записи', 'url' => ['/blog/admin/post']];
        $this->params['admin'][] = ['label' => 'Добавить запись', 'url' => ['/blog/admin/post/create']];
        $this->params['admin'][] = ['label' => 'Категории', 'url' => ['/blog/admin/category']];
        if ($page->id) {
            $this->params['admin'][] = ['label' => 'Редактировать страницу', 'url' => ['/page/admin/page/update', 'id' => $page->id]];
        }
    }
    if (Yii::$app->moduleManager->allowed('blog') && Yii::$app->moduleManager->allowed('comment')) {
        $this->params['admin'] = array_merge($this->params['admin'] ?? [], Yii::$app->moduleManager->notifications(Yii::$app->controller->module->id));
    }
}
?>

<h1><?= CHtml::encode($page->title) ?></h1>

<?php if (Yii::app()->request->getParam('page', 1) > 1) :
?>
<noindex><?php
    endif; ?>
    <?= $this->decodeWidgets(trim($page->text_purified)) ?>
    <?php if (Yii::app()->request->getParam('page', 1) > 1) :
    ?></noindex><?php
endif; ?>

<?= $this->render('_loop', ['dataProvider' => $dataProvider]); ?>
