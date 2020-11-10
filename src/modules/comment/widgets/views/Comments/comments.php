<?php
/** @var $comments Comment[] */
/** @var $user User */
/** @var $form CommentForm */
/** @var $authorId int */

use app\modules\comment\forms\CommentForm;
use app\modules\comment\models\Comment;
use app\modules\user\models\User;

?>
<div id="comments">

    <div class="block-title">Комментарии</div>

    <div id="commentsList">
        <?= $this->render('_tree', [
            'indent' => 0,
            'comments' => $comments,
            'parent' => 0,
            'user' => $user,
            'authorId' => $authorId,
        ]) ?>
    </div>

    <?php if (count($comments)) : ?>
        <p class="reply-comment"><a href="#comment-form">Оставить комментарий</a></p>
    <?php endif; ?>

    <?= $this->render('_form', [
        'form' => $form,
        'user' => $user,
    ]) ?>

</div>
