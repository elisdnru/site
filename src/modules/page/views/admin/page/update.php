<?php
/** @var $model Page */

$this->title = 'Редактор страниц';
$this->params['breadcrumbs'] = [
    'Страницы' => ['index'],
    'Редактор',
];

$this->params['admin'][] = ['label' => 'Cтраницы', 'url' => ['index']];
$this->params['admin'][] = ['label' => 'Просмотр', 'url' => $model->getUrl()];
if (Yii::$app->moduleManager->allowed('menu')) {
    $this->params['admin'][] = ['label' => 'Пункты меню', 'url' => ['/menu/admin/menu/index']];
}

use app\modules\page\models\Page; ?>

<h1>Редактирование страницы</h1>

<?= $this->render('_form', ['model' => $model]) ?>

