<?php
/** @var $model Page */

$this->title = 'Редактор страниц';
$this->params['breadcrumbs'] = [
    'Страницы' => ['index'],
    'Редактор',
];

$this->params['admin'][] = ['label' => 'Страницы', 'url' => ['index']];
$this->params['admin'][] = ['label' => 'Просмотр', 'url' => $model->getUrl()];

use app\modules\page\models\Page; ?>

<h1>Редактирование страницы</h1>

<?= $this->render('_form', ['model' => $model]) ?>

