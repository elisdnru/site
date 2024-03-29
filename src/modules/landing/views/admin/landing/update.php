<?php declare(strict_types=1);

use app\modules\landing\forms\admin\LandingForm;
use app\modules\landing\models\Landing;
use yii\web\View;

/**
 * @var View $this
 * @var Landing $landing
 * @var LandingForm $model
 */
$this->title = 'Редактор лендингов';
$this->params['breadcrumbs'] = [
    'Лендинги' => ['index'],
    'Редактор',
];

$this->params['admin'][] = ['label' => 'Лендинги', 'url' => ['index']];
$this->params['admin'][] = ['label' => 'Просмотр', 'url' => ['/landing/landing/show', 'path' => $landing->getPath()]];
if (Yii::$app->moduleAdminAccess->isGranted('page')) {
    $this->params['admin'][] = ['label' => 'Страницы', 'url' => ['/page/admin/page/index']];
}
?>

<h1>Редактирование лендинга</h1>

<?= $this->render('_form', ['model' => $model]); ?>

