<article id="photo_<?php echo $data->id; ?>" class="entry greed">
    <?php if ($data->file): ?>
        <p class="thumb"><a href="<?php echo $data->url; ?>"><img src="<?php echo $data->getImageThumbUrl(218, 180); ?>" alt="" /></a></p>
        <?php if ($data->user_id == Yii::app()->user->id): ?>
            <a class="delete ajax_del" title="Удалить фотографию" data-del="photo_<?php echo $data->id; ?>" href="<?php echo Yii::app()->createUrl('/userphoto/photo/delete', array('id'=>$data->id)); ?>"></a>
        <?php endif; ?>
    <?php endif; ?>
<div class="clear"></div>
</article>