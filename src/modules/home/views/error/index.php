<?php
use app\modules\page\models\Page;
use app\modules\user\models\Access;

/** @var $page Page */

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */
/* @var $exception Exception */

$this->title = 'Ошибка';
$this->params['breadcrumbs'] = [
    'Ошибка ' . ($error['code'] ?? ''),
];
?>

<?php if (Yii::$app->user->can(Access::CONTROL)) {
    $this->params['admin'][] = ['label' => 'Вернуться на сайт', 'url' => '/index'];
} ?>

<h2><?= $name ?></h2>

<p>Так получилось...</p>
<p><a href="/">На главную</a></p>
