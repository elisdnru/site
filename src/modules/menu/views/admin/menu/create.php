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

$this->admin[] = ['label' => 'Пункты меню', 'url' => $this->createUrl('index')];
if (Yii::app()->moduleManager->allowed('page')) {
    $this->admin[] = ['label' => 'Создать страницу', 'url' => $this->createUrl('admin/pages/update')];
}
?>

<h1>Добавление пункта меню</h1>

<?php $this->renderPartial('_form', ['model' => $model]); ?>

