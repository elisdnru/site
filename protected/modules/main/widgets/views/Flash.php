<?php Yii::app()->clientScript->registerScriptFile('swfobject.js'); ?>

<?php $id = 'flash_'. md5(rand(0, 100000)); ?>

<div class='flash' style='width:<?php echo $width; ?>px; height:<?php echo $height; ?>px;'>
    <div id='<?php echo $id; ?>'></div>
    <script type='text/javascript'>
        /* <![CDATA[ */
        var params = {vmode: 'window', allowfullscreen: 'true', allowScriptAccess: 'always'};
        var attrs = {};
        var flash = swfobject.embedSWF("<?php echo CHtml::encode($src); ?>", '<?php echo $id; ?>', '<?php echo $width; ?>', '<?php echo $height; ?>', '9', null, null, params, attrs);
        /* ]]> */
    </script>
</div>