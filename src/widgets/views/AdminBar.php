<?php

use yii\helpers\Url;
use yii\widgets\Menu;

?>
<div class="adminblock">
    <div class="adminlinks">
        <p class="nomargin" style="float: right">
            <a href="<?= Url::to(['/admin/default/index']) ?>"><img src="/images/admin/settings.png" title="Панель управления" alt="Панель управления"></a><a href="<?= Url::to(['/user/default/logout']) ?>"><img src="/images/admin/del.png" alt="Выход" title="Выход"></a>
        </p>

        <?= Menu::widget([
            'id' => 'admin_nav',
            'items' => $links,
            'activateItems' => false,
        ]) ?>

        <div class="clear"></div>
    </div>
</div>
