<div class="adminblock">
    <div class="adminlinks">
        <p class="nomargin" style="float: right">
            <a href="<?php echo Yii::app()->createUrl('/admin/default/index'); ?>"><img src="/images/admin/settings.png" title="Панель управления" alt="Панель управления" /></a><a href="<?php echo Yii::app()->createUrl('/user/default/logout'); ?>"><img src="/images/admin/del.png" alt="Выход" title="Выход" /></a>
        </p>

        <?php
        Yii::app()->controller->widget('zii.widgets.CMenu', [
            'items' => $links
        ]); ?>

        <div class="clear"></div>
    </div>
</div>
