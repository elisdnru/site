<?php

use app\components\InlineWidgetsBehavior;
use app\components\PaginationFormatter;
use app\modules\page\models\Page;
use app\modules\user\models\Access;
use yii\helpers\Html;
use yii\web\View;

/** @var $this View|InlineWidgetsBehavior */
/** @var $dataProvider \yii\data\ActiveDataProvider */

$this->context->layout = 'index';

$this->title = 'Блог' . PaginationFormatter::appendix($dataProvider->getPagination()->getPage() + 1);

$this->registerMetaTag([
    'name' => 'description',
    'content' => 'Официальный блог web-разработчика Дмитрия Елисеева. Статьи по разработке сайтов на фреймворках, программированию на PHP, рефакторингу web-приложений и повышению личной продуктивности. ' . PaginationFormatter::appendix($dataProvider->getPagination()->getPage() + 1)
]);

$this->params['breadcrumbs'] = [
    'Блог',
];

if (Yii::$app->user->can(Access::CONTROL)) {
    if (Yii::$app->moduleManager->allowed('blog')) {
        $this->params['admin'][] = ['label' => 'Записи', 'url' => ['/blog/admin/post']];
        $this->params['admin'][] = ['label' => 'Добавить запись', 'url' => ['/blog/admin/post/create']];
        $this->params['admin'][] = ['label' => 'Категории', 'url' => ['/blog/admin/category']];
    }
    if (Yii::$app->moduleManager->allowed('blog') && Yii::$app->moduleManager->allowed('comment')) {
        $this->params['admin'] = array_merge($this->params['admin'] ?? [], Yii::$app->moduleManager->notifications(Yii::$app->controller->module->id));
    }
}
?>

<h1>Официальный блог</h1>

<?= $this->render('_loop', ['dataProvider' => $dataProvider]) ?>
