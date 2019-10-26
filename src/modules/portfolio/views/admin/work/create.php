<?php
/** @var $model Work */
$this->title = 'Редактор работы';
$this->params['breadcrumbs'] = [
    'Панель управления' => ['/admin'],
    'Портфолио' => ['index'],
    'Редактор',
];

$this->params['admin'][] = ['label' => 'Работы', 'url' => ['index']];
$this->params['admin'][] = ['label' => 'Категории', 'url' => ['/portfolio/admin/category/index']];

use app\modules\portfolio\models\Work; ?>

<h1>Добавление работы</h1>

<?= $this->renderPartial('_form', ['model' => $model]); ?>
