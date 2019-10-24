<?php
/** @var $data Work */

use app\modules\portfolio\models\Work;

?>
<div class="entry greed">

    <p class="thumb">
        <a href="<?= $data->url ?>" style="background-image: url('<?= $data->getImageThumbUrl(198) ?>')"><span><?= CHtml::encode($data->title) ?></span></a>
    </p>

</div>
