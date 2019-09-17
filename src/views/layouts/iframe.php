<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8" />

    <?php Yii::app()->clientScript->registerCssFile('iframe.css'); ?>
    <?php Yii::app()->clientScript->registerScriptFile('site.js', CClientScript::POS_END); ?>

    <title><?php echo CHtml::encode($this->pageTitle) . ' - ' . Yii::app()->params['GENERAL.SITE_NAME']; ?></title>
</head>
<body>
<?php echo $content; ?>
</body>

<!-- <?php echo sprintf('%0.3f', Yii::getLogger()->getExecutionTime()); ?>с. <?php echo round(memory_get_peak_usage() / (1024 * 1024), 2) . "MB"; ?> -->

</html>
