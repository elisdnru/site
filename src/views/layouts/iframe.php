<?php
use app\modules\main\components\Controller;

$assetsVersion = @filemtime(dirname(__DIR__, 3) . '/public/build');

/** @var $this Controller */
?><!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8" />

    <?php Yii::app()->clientScript->registerPackage('iframe'); ?>
    <?php Yii::app()->clientScript->registerScriptFile('/build/site.js?v=' . $assetsVersion, CClientScript::POS_END, ['async' => true]); ?>

    <title><?php echo CHtml::encode($this->pageTitle) . ' - ' . Yii::app()->params['GENERAL.SITE_NAME']; ?></title>
</head>
<body>
<?php echo $content; ?>
</body>

<!-- <?php echo sprintf('%0.3f', Yii::getLogger()->getExecutionTime()); ?>с. <?php echo round(memory_get_peak_usage() / (1024 * 1024), 2) . "MB"; ?> -->

</html>
