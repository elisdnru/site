<?php
/** @var $model \app\modules\page\models\Page */

$this->title = 'Редактор страниц';
$this->params['breadcrumbs'] = [
    'Панель управления' => ['/admin'],
    'Страницы' => ['index'],
    'Редактор',
];

$this->admin[] = ['label' => 'Cтраницы', 'url' => $this->createUrl('index')];
$this->admin[] = ['label' => 'Просмотр', 'url' => $model->getUrl()];
if (Yii::app()->moduleManager->allowed('menu')) {
    $this->admin[] = ['label' => 'Пункты меню', 'url' => $this->createUrl('/menu/admin/menu/index')];
}
?>

<h1>Редактирование страницы</h1>

<?php $this->renderPartial('_form', ['model' => $model]); ?>

