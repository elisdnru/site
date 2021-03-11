<?php
use app\components\DateFormatter;
use app\components\purifier\CommentPostFilter;
use app\components\SocNetwork;
use app\modules\comment\models\Comment;
use app\modules\user\models\User;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\Session;

/**
 * @var int $indent
 * @var int $authorId
 * @var Comment $comment
 * @var User|null $user
 * @var Session $session
 */
$session = Yii::$app->get('session');
?>
<article class="comment<?= $authorId == $comment->user_id ? ' author' : '' ?>" id="comment_<?= $comment->id ?>" style="margin-left:<?= $indent < 8 ? $indent * 20 : 8 * 20 ?>px">
    <img class="userpic" src="<?= Html::encode($comment->getAvatarUrl(50, 50)) ?>" alt="">

    <header>
        <span class="link">
            <?php if ($user !== null && $comment->user && $user->id == $comment->user_id) : ?>
                <a rel="nofollow" href="<?= Url::to(['/comment/comment/update', 'id' => $comment->id]) ?>" title="Изменить комментарий"><img src="/images/admin/edit.png" width="16" height="16" alt="Изменить комментарий" title="Изменить комментарий"></a>
            <?php endif; ?>
            <?php if ($user !== null && $comment->user && $user->id == $comment->user_id) : ?>
                <a rel="nofollow" class="ajax-del" data-del="comment_<?= $comment->id ?>" href="<?= Url::to(['/comment/ajax/delete', 'id' => $comment->id]) ?>" title="Удалить комментарий"><img src="/images/admin/del.png" width="16" height="16" alt="Удалить" title="Удалить"></a>
            <?php endif; ?>
        </span>

        <span class="like">
            <span id="like-<?= $comment->id ?>"><?= $comment->likes ?></span>
            <span class="ajax-like like-icon<?= $comment->getLiked($session) ? ' like-active' : '' ?>" data-load="like-<?= $comment->id ?>" data-url="<?= Url::to(['/comment/ajax/like', 'id' => $comment->id]) ?>" title="Мне нравится"></span>
        </span>

        <h2 class="date enc-date" data-date="<?= DateFormatter::format($comment->date, true) ?>">&nbsp;</h2>

        <?php if ($comment->user && $comment->user->network) : ?>
            <a href="<?= $comment->user->identity ?>"><?= SocNetwork::icon($comment->user->network) ?></a>
        <?php endif; ?>

        <span class="author">
            <?php if (!empty($comment->site) && !empty($comment->name)) : ?>
                <cite><a href="<?= Html::encode($comment->site) ?>"><?= Html::encode($comment->name) ?></a></cite>
            <?php elseif (!empty($comment->name)) : ?>
                <cite><?= Html::encode($comment->name) ?></cite>
            <?php else : ?>
                <cite><em>Неизвестный</em></cite>
            <?php endif; ?>
        </span>

    </header>

    <div class="text">
        <?php if ($comment->public) : ?>
            <?= CommentPostFilter::fixMarkup($comment->text_purified) ?>
        <?php else : ?>
            <em>Комментарий удалён</em>
        <?php endif; ?>
    </div>

    <div class="clear"></div>
    <footer><span data-id="<?= $comment->id ?>" class="reply">Ответить</span></footer>

</article>
