<div style="float:left; margin-bottom:10px">

    <a href="<?php use app\modules\main\components\helpers\DSocNetworkHelper;

    echo $data->url; ?>"><img src="<?php echo $data->avatarUrl; ?>" alt="" width="50" /></a>

</div>

<div style="margin-left:70px;">

    <h4 class="nomargin">
        <?php if ($data->network) : ?>
            <a rel="nofollow" href="<?php echo $data->identity; ?>"><img style="vertical-align: middle" src="<?php echo DSocNetworkHelper::getIcon($data->network); ?>" /></a>
        <?php endif; ?>
        <a href="<?php echo $data->url; ?>"><?php echo CHtml::encode($data->name . ' ' . $data->lastname); ?></a>
    </h4>

    <p class="nomargin">Комментариев: <?php echo CHtml::encode($data->comments_count); ?></p>

</div>

<div class="clear"></div>

<hr />

