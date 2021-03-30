<?php

use app\components\purifier\CommentPostFilter;
use app\components\SocNetwork;
use app\modules\comment\models\Comment;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\Session;

/**
 * @var Comment $comment
 * @var Session $session
 */
$session = Yii::$app->get('session');

$editurl = Url::to(['update', 'id' => $comment->id]);
$delUrl = Url::to(['delete', 'id' => $comment->id]);
$publicurl = Url::to(['toggle', 'attribute' => 'public', 'id' => $comment->id]);
$moderurl = Url::to(['toggle', 'attribute' => 'moder', 'id' => $comment->id]);
?>

<article class="comment<?= !$comment->moder ? ' newcomment' : '' ?><?= !$comment->public ? ' nopublcomment' : '' ?>" id="comment_<?= $comment->id ?>">
    <img class="userpic" src="<?= Html::encode($comment->getAvatarUrl(50, 50)) ?>" alt="">

    <header>

        <span class="link">
            <a class="ajax-post" title="Прочитать/Вернуть комментарий" href="<?= $moderurl ?>"><img src="/images/admin/yes.png" width="16" height="16" alt="<?php echo $comment->public ? 'Прочесть' : 'Новый' ?>" title="<?= $comment->public ? 'Прочесть' : 'Новый' ?>"></a>
            <a class="ajax-post" title="Скрыть/отобразить комментарий" href="<?= $publicurl ?>"><img src="/images/admin/no.png" width="16" height="16" alt="<?= $comment->public ? 'Скрыть' : 'Опубликовать' ?>" title="<?= $comment->public ? 'Скрыть' : 'Опубликовать' ?>"></a>
            <a href="<?= $editurl ?>"><img src="/images/admin/edit.png" width="16" height="16" alt="Редактировать" title="Редактировать"></a>
            <a class="ajax-del" data-del="comment_<?= $comment->id ?>" title="Удалить комментарий" href="<?= $delUrl ?>"><img src="/images/admin/del.png" width="16" height="16" alt="Удалить" title="Удалить"></a>
        </span>

        <span class="like">
            <span id="like-<?= $comment->id ?>"><?= $comment->likes ?></span>
            <a rel="nofollow" class="ajax-load like-icon<?= $comment->getLiked($session) ? ' like-active' : '' ?>" data-load="like-<?= $comment->id ?>" href="<?= Url::to(['/comment/ajax/like', 'id' => $comment->id]) ?>" title="Мне нравится"></a>
        </span>

        <h2 class="date"><?= $comment->date ?></h2>

        <?php if ($comment->user && $comment->user->network) : ?>
            <a target="_blank" rel="nofollow" href="<?= $comment->user->identity ?>"><?= SocNetwork::icon($comment->user->network) ?></a>
        <?php endif; ?>

        <span class="author">
            <?php if (!empty($comment->site) && !empty($comment->name)) : ?>
                <cite><a rel="nofollow" href="<?= Html::encode($comment->site) ?>"><?= Html::encode($comment->name) ?></a></cite>
            <?php elseif (!empty($comment->name)) : ?>
                <?= Html::encode($comment->name) ?>
            <?php else : ?>
                <i>Неизвестный</i>
            <?php endif; ?>
        </span>

    </header>

    <div class="text">
        <?= CommentPostFilter::fixMarkup($comment->text_purified) ?>
        <p>
            <a href="<?= $comment->getUrl() ?>"><?= Html::encode($comment->material->getCommentTitle()) ?></a>
        </p>
    </div>

    <div class="clear"></div>

</article>
