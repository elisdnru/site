<div class="adminblock">
    <div class="admininfo">
        <p><?php echo $info; ?>&nbsp;</p>
    </div>
    <div class="adminlinks">
        <p class="floatright nomargin"><a href="<?php echo Yii::app()->createUrl('/admin/default/index'); ?>"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/admin/settings.png" title="Панель управления" alt="Панель управления" /></a><a href="<?php echo Yii::app()->createUrl('/user/default/logout'); ?>"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/admin/del.png" alt="Выход" title="Выход" /></a></p>

        <?php
        Yii::app()->controller->widget('zii.widgets.CMenu',array(
            'items'=>$links
        )); ?>

    <div class="clear"></div>
    </div>
</div>