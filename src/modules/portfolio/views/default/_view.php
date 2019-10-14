<?php
/** @var $data \app\modules\portfolio\models\Work */
?>
<div class="entry greed">

    <p class="thumb">
        <a href="<?php echo $data->url; ?>" style="background-image: url('<?php echo $data->getImageThumbUrl(198, 0); ?>')"><span><?php echo CHtml::encode($data->title); ?></span></a>
    </p>

</div>
