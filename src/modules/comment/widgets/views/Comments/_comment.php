<?php
/** @var $indent int */
/** @var $authorId int */
/** @var $comment \app\modules\comment\models\Comment */
/** @var $user \app\modules\user\models\User */
?>
<article class="comment<?php use app\components\helpers\DateHelper;
use app\components\helpers\SocNetworkHelper;
use app\components\helpers\TextHelper;

if ($authorId == $comment->user_id) :
    ?> author<?php
endif; ?>" id="comment_<?= $comment->id ?>" style="margin-left:<?= $indent < 8 ? $indent * 20 : 8 * 20 ?>px">

    <?php if ($comment->cache(1000)->user) :
        ?>
        <img class="userpic" src="<?= $comment->getAvatarUrl(50, 50) ?>" alt="">
    <?php
    else :
        ?>
        <img class="userpic" src="<?= CHtml::encode($comment->getAvatarUrl(50, 50)) ?>" alt="">
    <?php
    endif; ?>

    <header>

        <span class="link">
            <?php if ($user && $comment->user && $user->id == $comment->user_id) :
                ?>
                <a rel="nofollow" href="<?= Yii::app()->createUrl('comment/comment/update', ['id' => $comment->id]) ?>" title="Изменить комментарий"><img src="/images/admin/edit.png" width="16" height="16" alt="Изменить комментарий" title="Изменить комментарий"></a>
            <?php endif; ?>
            <?php if ($user && $comment->user && $user->id == $comment->user_id) :
                ?>
                <a rel="nofollow" class="ajax_del" data-del="comment_<?= $comment->id ?>" href="<?= Yii::app()->createUrl('comment/ajax/delete', ['id' => $comment->id]) ?>" title="Удалить комментарий"><img src="/images/admin/del.png" width="16" height="16" alt="Удалить" title="Удалить"></a>
            <?php endif; ?>
        </span>

        <span class="like">
            <span id="like_<?= $comment->id ?>"><?= $comment->likes ?></span>
            <span class="ajax_like like_icon<?php if ($comment->liked) :
                ?> like_active<?php
            endif; ?>" data-load="like_<?= $comment->id ?>" data-url="<?= Yii::app()->createUrl('comment/ajax/like', ['id' => $comment->id]) ?>" title="Мне нравится"></span>
        </span>

        <h2 class="date enc-date" data-date="<?= DateHelper::normdate($comment->date, true) ?>">&nbsp;</h2>

        <?php if ($comment->user && $comment->user->network): ?>
            <a href="<?= $comment->user->identity ?>"><?= SocNetworkHelper::getIcon($comment->user->network) ?></a>
        <?php endif; ?>

        <span class="author">
            <?php if ($comment->site) :
                ?>
                <cite><a href="<?= CHtml::encode($comment->site) ?>"><?= CHtml::encode($comment->name) ?></a></cite>
            <?php
            elseif ($comment->name) :
                ?>
                <cite><?= CHtml::encode($comment->name) ?></cite>
            <?php
            else :
                ?>
                <cite><em>Неизвестный</em></cite>
            <?php
            endif; ?>
        </span>

    </header>

    <div class="text">
        <?php if ($comment->public) :
            ?>

            <?= TextHelper::fixBR($comment->text_purified) ?>

        <?php
        else :
            ?>
            <em>Комментарий удалён</em>
        <?php
        endif; ?>
    </div>

    <div class="clear"></div>
    <footer><span data-id="<?= $comment->id ?>" class="reply">Ответить</span></footer>

</article>
