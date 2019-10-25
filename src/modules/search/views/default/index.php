<?php
/** @var $this Controller */

use app\components\Controller;
use app\components\helpers\NumberHelper;
use app\modules\search\widgets\SearchFormWidget;
use app\modules\user\models\Access;
use yii\data\ActiveDataProvider;

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

if (Yii::app()->user->checkAccess(Access::CONTROL)) {
    if (Yii::app()->moduleManager->allowed('blog')) {
        $this->params['admin'][] = ['label' => 'Записи', 'url' => $this->createUrl('/blog/admin/post')];
    }
    if (Yii::app()->moduleManager->allowed('page')) {
        $this->params['admin'][] = ['label' => 'Страницы', 'url' => $this->createUrl('/page/admin/page')];
    }
}
?>

<h1>Поиск по сайту</h1>

<?= SearchFormWidget::widget() ?>

<?= $this->renderPartial('_loop', [
    'dataProvider' => $dataProvider,
    'query' => $query,
]); ?>
