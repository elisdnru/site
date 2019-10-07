<div id="comments">

    <div class="block-title">Комментарии</div>

    <div id="commentsList">
        <?php $this->render('Comments/_tree', [
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

    <?php $this->render('Comments/_form', [
        'form' => $form,
        'user' => $user,
    ]); ?>

</div>
