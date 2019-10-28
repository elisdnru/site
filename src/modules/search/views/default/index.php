<?php
use app\components\helpers\NumberHelper;
use app\modules\search\widgets\SearchFormWidget;
use app\modules\user\models\Access;
use yii\data\ActiveDataProvider;

/** @var $this \yii\web\View */
/** @var $dataProvider ActiveDataProvider */
/** @var $query CActiveRecord */

$this->title = 'Поиск по сайту' . NumberHelper::pageString($dataProvider->getPagination()->pageParam);

$this->registerMetaTag([
    'name' => 'description',
    'content' => 'Поиск по сайту' . NumberHelper::pageString($dataProvider->getPagination()->pageParam),
]);

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

<?= $this->render('_loop', [
    'dataProvider' => $dataProvider,
    'query' => $query,
]); ?>
