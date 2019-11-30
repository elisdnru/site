<?php
use app\components\NumberHelper;
use app\modules\user\models\Access;

/** @var $this \yii\web\View */
/** @var $date string */
/** @var $dataProvider CActiveDataProvider */

$this->context->layout = 'index';

$this->title = 'Записи за ' . $date . NumberHelper::pageString($dataProvider->getPagination()->pageVar);

$this->params['breadcrumbs'] = [
    'Блог' => ['/blog/default/index'],
    'Записи от ' . $date,
];

if (Yii::$app->user->can(Access::CONTROL)) {
    if (Yii::$app->moduleManager->allowed('blog')) {
        $this->params['admin'][] = ['label' => 'Редактировать записи', 'url' => ['/blog/admin/post']];
        $this->params['admin'][] = ['label' => 'Добавить запись', 'url' => ['/blog/admin/post/create']];
    }
}
?>

<h1>Записи от <?= $date ?></h1>

<?= $this->render('_loop', ['dataProvider' => $dataProvider]); ?>
