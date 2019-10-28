<?php

/** @var $model Work */

$this->title = 'Редактор работы';
$this->params['breadcrumbs'] = [
    'Портфолио' => ['index'],
    'Редактор',
];

$this->params['admin'][] = ['label' => 'Просмотр', 'url' => $model->url];
$this->params['admin'][] = ['label' => 'Работы', 'url' => ['index']];
$this->params['admin'][] = ['label' => 'Категории', 'url' => ['/portfolio/admin/category/index']];

use app\modules\portfolio\models\Work; ?>

<h1>Редактирование работы</h1>

<?= $this->render('_form', ['model' => $model]); ?>
