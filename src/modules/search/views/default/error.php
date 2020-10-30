<?php
use app\modules\search\widgets\SearchFormWidget;
use app\modules\user\models\Access;
use yii\data\ActiveDataProvider;
use yii\web\View;

/** @var $this View */
/** @var $dataProvider ActiveDataProvider */

$this->title = 'Поиск по сайту';

$this->registerMetaTag(['name' => 'description', 'content' => 'Поиск по сайту']);

$this->params['breadcrumbs'] = [
    'Поиск по сайту',
];

if (Yii::$app->user->can(Access::CONTROL)) {
    if (Yii::$app->moduleManager->allowed('blog')) {
        $this->params['admin'][] = ['label' => 'Записи', 'url' => ['/blog/admin/post']];
    }
    if (Yii::$app->moduleManager->allowed('page')) {
        $this->params['admin'][] = ['label' => 'Страницы', 'url' => ['/page/admin/page']];
    }
}
?>

<h1>Поиск по сайту</h1>

<?= SearchFormWidget::widget() ?>

<p>Введите запрос</p>
