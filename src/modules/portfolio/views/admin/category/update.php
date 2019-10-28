<?php

/** @var $model Category */

$this->title = 'Редактор категории портфолио';
$this->params['breadcrumbs'] = [
    'Портфолио' => ['/portfolio/admin/work/index'],
    'Категории' => ['index'],
    'Редактор',
];

$this->params['admin'][] = ['label' => 'Категории', 'url' => ['index']];
$this->params['admin'][] = ['label' => 'Работы', 'url' => ['/portfolio/admin/work/index']];

use app\modules\portfolio\models\Category; ?>

<h1>Редактирование категории портфолио</h1>

<?= $this->render('_form', ['model' => $model]); ?>
