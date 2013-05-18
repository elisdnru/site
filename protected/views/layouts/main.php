<!doctype html>
<html lang="<?php echo Yii::app()->language; ?>">
<head>
    <meta charset="utf-8" />
    <link type="text/css" rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/core/css/system.css" />
    <!--[if lt IE 9]><script src="<?php echo Yii::app()->request->baseUrl; ?>/core/js/html5.js"></script><![endif]-->
    <title>...</title>
</head>
<body>

<div id="wrapper">

    <?php  if(count($this->admin)) : ?>
        <div class="adminbar">
            <?php $this->widget('DAdminlinksWidget', array(
                'links'=>$this->admin,
                'info'=>$this->info
            )); ?>
        </div>
    <?php endif; ?>

    <div id="content">

        <!-- Контент -->
        <?php echo $content; ?>
        <!-- /Контент -->

        <div class="clear"></div>

    </div>
</div>

<!-- <?php echo sprintf('%0.3f',Yii::getLogger()->getExecutionTime()) ?>с. <?php echo round(memory_get_peak_usage()/(1024*1024),2)."MB" ?> -->

</body>
</html>