<?php

use app\modules\page\models\Page;
use app\modules\user\models\Access;

/** @var $page Page */
$this->title = 'Error';
$this->params['breadcrumbs'] = [
    'Ошибка ' . ($error['code'] ?? ''),
];
?>

<?php if (Yii::app()->user->checkAccess(Access::ROLE_CONTROL)) {
    $this->params['admin'][] = ['label' => 'Вернуться на сайт', 'url' => '/index'];
} ?>

<h2>Ошибка <?php echo $error['code'] ?? ''; ?></h2>

<?php if (YII_DEBUG) : ?>
    <p><?php echo isset($error['message']) ? CHtml::encode($error['message']) : ''; ?></p>

    <p>File: <?php echo isset($error['file']) ? CHtml::encode($error['file']) : ''; ?></p>
    <p>Line: <?php echo isset($error['line']) ? CHtml::encode($error['line']) : ''; ?></p>
<?php endif; ?>

<?php echo $this->decodeWidgets(trim($page->text_purified)); ?>
