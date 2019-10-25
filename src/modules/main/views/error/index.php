<?php

use app\modules\page\models\Page;
use app\modules\user\models\Access;

/** @var $page Page */
$this->title = 'Ошибка';
$this->params['breadcrumbs'] = [
    'Ошибка ' . ($error['code'] ?? ''),
];
?>

<?php if (Yii::app()->user->checkAccess(Access::ROLE_CONTROL)) {
    $this->params['admin'][] = ['label' => 'Вернуться на сайт', 'url' => '/index'];
} ?>

<h2>Ошибка <?= $error['code'] ?? '' ?></h2>

<?php if (YII_DEBUG) : ?>
    <p><?= isset($error['message']) ? CHtml::encode($error['message']) : '' ?></p>

    <p>File: <?= isset($error['file']) ? CHtml::encode($error['file']) : '' ?></p>
    <p>Line: <?= isset($error['line']) ? CHtml::encode($error['line']) : '' ?></p>
<?php endif; ?>

<p>Так получилось...</p>
<p><a href="/">На главную</a></p>
