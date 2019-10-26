<?php
/** @var $model Landing */

use app\modules\landing\models\Landing;

$this->title = 'Редактор лендингов';
$this->params['breadcrumbs'] = [
    'Панель управления' => ['/admin'],
    'Лендинги' => ['index'],
    'Редактор',
];

$this->params['admin'][] = ['label' => 'Лендинги', 'url' => $this->createUrl('index')];
$this->params['admin'][] = ['label' => 'Просмотр', 'url' => $model->getUrl()];
if (Yii::$app->moduleManager->allowed('page')) {
    $this->params['admin'][] = ['label' => 'Cтраницы', 'url' => $this->createUrl('/page/admin/page/index')];
}
?>

<h1>Редактирование лендинга</h1>

<?= $this->renderPartial('_form', ['model' => $model]); ?>

