<?php
/** @var $model \app\modules\page\models\Page */
$this->pageTitle = 'Редактор страниц';
$this->breadcrumbs = [
    'Панель управления' => ['/admin'],
    'Страницы' => ['index'],
    'Редактор',
];

$this->admin[] = ['label' => 'Cтраницы', 'url' => $this->createUrl('index')];
if (Yii::app()->moduleManager->allowed('menu')) {
    $this->admin[] = ['label' => 'Пункты меню', 'url' => $this->createUrl('/menu/admin/menu/index')];
}
?>

<h1>Добавление страницы</h1>

<?php $this->renderPartial('_form', ['model' => $model]); ?>

