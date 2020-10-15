<?php
/** @var $model Page */
$this->title = 'Редактор страниц';
$this->params['breadcrumbs'] = [
    'Страницы' => ['index'],
    'Редактор',
];

$this->params['admin'][] = ['label' => 'Страницы', 'url' => ['index']];

use app\modules\page\models\Page; ?>

<h1>Добавление страницы</h1>

<?= $this->render('_form', ['model' => $model]) ?>

