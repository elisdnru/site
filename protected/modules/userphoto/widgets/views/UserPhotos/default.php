
<?php $this->widget('colorbox.widgets.ColorboxWidget'); ?>

<?php if ($photos): ?>

    <?php $limit = Yii::app()->config->get('USERPHOTO.MAX_COUNT'); ?>
    <?php $i = 0; ?>

    <div class="<?php echo $class; ?>">
        <ul>
            <?php foreach ($photos as $photo): ?>

                <?php if (++$i >= $limit) break; ?>

                <li id="photo_<?php echo $photo->id; ?>">
                    <?php echo CHtml::link(CHtml::image($photo->getImageThumbUrl(50, 50), $photo->title), $photo->url, array('title'=>$photo->title)); ?>
                    <?php if ($user->id == Yii::app()->user->id): ?>
                        <a class="delete ajax_del" title="Удалить фотографию" data-del="photo_<?php echo $photo->id; ?>" href="<?php echo Yii::app()->createUrl('/userphoto/photo/delete', array('id'=>$photo->id)); ?>"></a>
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

<p><a href="<?php echo Yii::app()->createUrl('/userphoto/default/index', array('username'=>$user->username)); ?>">Все фотографии</a></p>




