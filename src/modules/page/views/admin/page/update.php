<?php

use app\modules\page\models\Page;
use yii\web\View;

/**
 * @var View $this
 * @var Page $model
 */

$this->title = 'Редактор страниц';
$this->params['breadcrumbs'] = [
    'Страницы' => ['index'],
    'Редактор',
];

$this->params['admin'][] = ['label' => 'Страницы', 'url' => ['index']];
$this->params['admin'][] = ['label' => 'Просмотр', 'url' => $model->getUrl()];
?>

<h1>Редактирование страницы</h1>

<?= $this->render('_form', ['model' => $model]) ?>

