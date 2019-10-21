<?php
/** @var $model \app\modules\page\models\Page */
$this->title = 'Редактор страниц';
$this->params['breadcrumbs'] = [
    'Панель управления' => ['/admin'],
    'Страницы' => ['index'],
    'Редактор',
];

$this->params['admin'][] = ['label' => 'Cтраницы', 'url' => $this->createUrl('index')];
if (Yii::app()->moduleManager->allowed('menu')) {
    $this->params['admin'][] = ['label' => 'Пункты меню', 'url' => $this->createUrl('/menu/admin/menu/index')];
}
?>

<h1>Добавление страницы</h1>

<?= $this->renderPartial('_form', ['model' => $model]); ?>

