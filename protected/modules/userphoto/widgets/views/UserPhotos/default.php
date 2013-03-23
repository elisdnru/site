
<?php $this->widget('colorbox.widgets.ColorboxWidget'); ?>

<?php if ($photos): ?>


    <div class="<?php echo $class; ?>">
        <ul>
            <?php foreach ($photos as $photo): ?>
            <li id="photo_<?php echo $photo->id; ?>">
                <?php echo CHtml::link(CHtml::image($photo->getThumbUrl(50, 50), $photo->title), $photo->url, array('class'=>'userphoto', 'title'=>$photo->title)); ?>
                <?php if ($user->id == Yii::app()->user->id): ?>
                    <a class="delete ajax_del" title="Удалить фотографию" data-del="photo_<?php echo $photo->id; ?>" href="<?php echo Yii::app()->createUrl('/userphoto/image/delete', array('id'=>$photo->id)); ?>"></a>
                <?php endif; ?>
            </li>
            <?php endforeach; ?>
        </ul>
        <div class="clear"></div>
    </div>

    <script type="text/javascript">
        jQuery('a.userphoto').colorbox({
            'rel': 'userphoto',
            'maxWidth' : '100%',
            'maxHeight' : '100%',
            'opacity' : 0.1,
            'current' : '{current} / {total}'
        });
    </script>

<?php else: ?>

    <p>Нет фотографий</p>

<?php endif; ?>

<?php
$count = UserPhoto::model()->user($user->id)->count();
$limit = Yii::app()->config->get('USERPHOTO.MAX_COUNT');
?>
<?php if ($count < $limit): ?>
<?php $this->render('UserPhotos/_form' , array(
    'model'=>$model,
    'user'=>$user,
)); ?>
<?php endif; ?>


