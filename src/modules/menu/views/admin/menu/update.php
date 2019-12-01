<?php
/** @var $this \yii\web\View */

use app\modules\menu\models\Menu;

/** @var $model Menu */

$this->title = 'Редактор меню';
$this->params['breadcrumbs'] = [
    'Меню' => ['index'],
    'Редактор',
];

$this->params['admin'][] = ['label' => 'Пункты меню', 'url' => ['index']];
if (Yii::$app->moduleManager->allowed('page')) {
    $this->params['admin'][] = ['label' => 'Создать страницу', 'url' => ['/page/admin/page/create']];
}
?>

<h1>Редактирование пункта меню</h1>

<?= $this->render('_form', ['model' => $model]) ?>

