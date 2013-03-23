
<article class="comment<?php if ($authorId == $comment->user_id): ?> author<?php endif; ?>" id="comment_<?php echo $comment->id; ?>" style="margin-left:<?php echo $indent < 8 ? $indent*20 : 5*20; ?>px">

    <?php if ($comment->cache(1000)->user): ?>
        <a href="<?php echo $comment->user->url; ?>"><img class="userpic" src="<?php echo $comment->getAvatarUrl(50, 50); ?>" /></a>
    <?php else: ?>
        <img class="userpic" src="<?php echo $comment->getAvatarUrl(50, 50); ?>" />
    <?php endif; ?>

    <header>

        <span class="link">
            <?php if (Yii::app()->controller->is('comment')): ?>
            <a rel="nofollow" class="ajax_del" data-del="comment_<?php echo $comment->id; ?>" href="<?php echo Yii::app()->createUrl('comment/ajax/hide', array('id'=>$comment->id)); ?>" title="Скрыть комментарий"><img src="/core/images/admin/yes.png" width="16" height="16" alt="<?php echo $comment->public ? 'Скрыть' : 'Опубликовать'; ?>" title="<?php echo $comment->public ? 'Скрыть' : 'Опубликовать'; ?>" /></a>
            <?php endif; ?>
            <?php if (Yii::app()->controller->is('comment') || ($user && $comment->user && $user->id == $comment->user_id)): ?>
            <a rel="nofollow" class="ajax_del" data-del="comment_<?php echo $comment->id; ?>" href="<?php echo Yii::app()->createUrl('comment/ajax/delete', array('id'=>$comment->id)); ?>" title="Удалить комментарий"><img src="/core/images/admin/del.png" width="16" height="16" alt="Удалить" title="Удалить" /></a>
            <?php endif; ?>
        </span>

        <span class="like">
            <span id="like_<?php echo $comment->id; ?>"><?php echo $comment->likes; ?></span>
            <a rel="nofollow" class="ajax_load like_icon<?php if ($comment->liked): ?> like_active<?php endif; ?>" data-load="like_<?php echo $comment->id; ?>" href="<?php echo Yii::app()->createUrl('comment/ajax/like', array('id'=>$comment->id)); ?>" title="Мне нравится"></a>
        </span>

        <span class="date"><?php echo $comment->date; ?></span>

        <?php if ($comment->user && $comment->user->network): ?><a target="_blank" rel="nofollow" href="<?php echo $comment->user->identity; ?>"><img style="vertical-align: middle" src="<?php echo DSocNetworkHelper::getIcon($comment->user->network); ?>" /></a><?php endif; ?>

        <span class="author">
            <?php if ($comment->site): ?>
                <cite><a rel="nofollow" href="<?php echo CHtml::encode($comment->site); ?>"><?php echo CHtml::encode($comment->name); ?></a></cite>
            <?php elseif ($comment->name): ?>
                <?php echo CHtml::encode($comment->name); ?>
            <?php else: ?>
                <i>Неизвестный</i>
            <?php endif; ?>
        </span>

    </header>

    <div class="text">
        <?php if($comment->public): ?>

            <?php echo DTextHelper::fixBR($comment->text_purified); ?>

        <?php else: ?>
            <em>Комментарий удалён</em>
        <?php endif; ?>
    </div>

    <div class="clear"></div>
    <footer><a rel="nofollow" data-id="<?php echo $comment->id; ?>" class="reply" href="#comment-form">Ответить</a></footer>

</article>