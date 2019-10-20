<?php
/** @var $this AdminController */

use app\components\AdminController;
use app\modules\menu\models\Menu;

/** @var $model Menu */

$this->title = 'Редактор меню';
$this->params['breadcrumbs'] = [
    'Панель управления' => ['/admin'],
    'Меню' => ['index'],
    'Редактор',
];

$this->params['admin'][] = ['label' => 'Пункты меню', 'url' => $this->createUrl('index')];
if (Yii::app()->moduleManager->allowed('page')) {
    $this->params['admin'][] = ['label' => 'Создать страницу', 'url' => $this->createUrl('/page/admin/page/create')];
}
?>

<h1>Редактирование пункта меню</h1>

<?php $this->renderPartial('_form', ['model' => $model]); ?>

