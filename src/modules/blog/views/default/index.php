<?php

use app\components\InlineWidgetsBehavior;
use app\components\PaginationFormatter;
use app\modules\page\models\Page;
use app\modules\user\models\Access;
use yii\helpers\Html;
use yii\web\View;

/** @var $this View|InlineWidgetsBehavior */
/** @var $page Page */
/** @var $dataProvider CActiveDataProvider */

$this->context->layout = 'index';

$this->title = $page->pagetitle . PaginationFormatter::appendix($dataProvider->getPagination()->getCurrentPage() + 1);

$this->registerMetaTag([
    'name' => 'description',
    'content' => $page->description . PaginationFormatter::appendix($dataProvider->getPagination()->getCurrentPage() + 1)
]);

$this->params['breadcrumbs'] = [
    'Блог',
];

if (Yii::$app->user->can(Access::CONTROL)) {
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

<h1><?= Html::encode($page->title) ?></h1>

<?php if (Yii::$app->request->get('page', 1) > 1) : ?>
    <!--noindex-->
<?php endif; ?>
<?= $this->decodeWidgets(trim($page->text_purified)) ?>
<?php if (Yii::$app->request->get('page', 1) > 1) : ?>
    <!--/noindex-->
<?php endif; ?>

<?= $this->render('_loop', ['dataProvider' => $dataProvider]) ?>
