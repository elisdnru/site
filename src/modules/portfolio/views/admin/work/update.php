<?php

/**
 * @var View $this
 * @var Work $model
 */

$this->title = 'Редактор работы';
$this->params['breadcrumbs'] = [
    'Портфолио' => ['index'],
    'Редактор',
];

$this->params['admin'][] = ['label' => 'Просмотр', 'url' => $model->getUrl()];
$this->params['admin'][] = ['label' => 'Работы', 'url' => ['index']];
$this->params['admin'][] = ['label' => 'Категории', 'url' => ['/portfolio/admin/category/index']];

use app\modules\portfolio\models\Work;
use yii\web\View; ?>

<h1>Редактирование работы</h1>

<?= $this->render('_form', ['model' => $model]) ?>
