<?php
/** @var $this \yii\web\View */

use app\components\Controller;
use app\components\DateLimiter;
use app\components\helpers\NumberHelper;
use app\modules\user\models\Access;

/** @var $date DateLimiter */
/** @var $dataProvider CActiveDataProvider */

$this->context->layout = 'index';

$this->title = 'Записи за ' . $date->date . NumberHelper::pageString($dataProvider->getPagination()->pageVar);

$this->params['breadcrumbs'] = [
    'Блог' => ['/blog/default/index'],
    'Записи от ' . $date->date,
];

if (Yii::app()->user->checkAccess(Access::CONTROL)) {
    if (Yii::$app->moduleManager->allowed('blog')) {
        $this->params['admin'][] = ['label' => 'Редактировать записи', 'url' => ['/blog/admin/post']];
        $this->params['admin'][] = ['label' => 'Добавить запись', 'url' => ['/blog/admin/post/create']];
    }
}
?>

<h1>Записи от <?= $date->date ?></h1>

<?= $this->render('_loop', ['dataProvider' => $dataProvider]); ?>
