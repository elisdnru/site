<?php
use app\modules\page\models\Page;
use app\modules\user\models\Access;

/** @var $page Page */

$this->title = 'Ошибка';
$this->params['breadcrumbs'] = [
    'Ошибка ' . ($error['code'] ?? ''),
];
?>

<?php if (Yii::app()->user->checkAccess(Access::CONTROL)) {
    $this->params['admin'][] = ['label' => 'Вернуться на сайт', 'url' => '/index'];
} ?>

<h2>Ошибка <?= $error['code'] ?? '' ?></h2>

<p>Так получилось...</p>
<p><a href="/">На главную</a></p>
