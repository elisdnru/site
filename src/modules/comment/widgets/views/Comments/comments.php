<?php
/** @var $comments \app\modules\comment\models\Comment[] */
/** @var $user \app\modules\user\models\User */
/** @var $authorId int */
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

    <?php if (count($comments)): ?>
        <p class="reply-comment"><a href="#comment-form">Оставить комментарий</a></p>
    <?php endif; ?>

    <?= $this->render('_form', [
        'form' => $form,
        'user' => $user,
    ]); ?>

</div>
