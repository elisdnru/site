<!doctype html>
<html lang="ru">
<head>

    <meta charset="utf-8"/>

    <link type="text/css" rel="stylesheet" href="/css/_system.css"/>
    <link type="text/css" rel="stylesheet" href="/css/_typo.css"/>
    <link type="text/css" rel="stylesheet" href="/css/_style.css"/>
    <link type="text/css" rel="stylesheet" href="/css/iframe.css"/>
    <!--[if lt IE 9]><script src="/js/html5.js"></script><![endif]-->

    <?php Yii::app()->clientScript->registerCoreScript('jquery'); ?>
    <?php Yii::app()->clientScript->registerScriptFile('jquery.plugins.js'); ?>
    <?php Yii::app()->clientScript->registerScriptFile('core-site.js'); ?>
    <?php Yii::app()->clientScript->registerScriptFile('core-end.js', CClientScript::POS_END); ?>
    <title><?php echo CHtml::encode($this->pageTitle) . ' - ' . Yii::app()->params['GENERAL.SITE_NAME']; ?></title>
</head>
<body>
<?php echo $content; ?>
</body>

<!-- <?php echo sprintf('%0.3f', Yii::getLogger()->getExecutionTime()); ?>с. <?php echo round(memory_get_peak_usage() / (1024 * 1024), 2) . "MB"; ?> -->

</html>
