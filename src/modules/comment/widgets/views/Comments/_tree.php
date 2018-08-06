
<?php if (isset($comments[$parent])) : ?>
    <?php foreach ($comments[$parent] as $comment) : ?>
        <?php $this->render('Comments/_comment', [
            'indent' => $indent,
            'comment' => $comment,
            'authorId' => $authorId,
            'user' => $user,
        ]); ?>

        <?php if ($indent < 100 && isset($comments[$comment->id]) && $comments[$comment->id]) : ?>
            <?php $this->render('Comments/_tree', [
                'indent' => $indent + 1,
                'comments' => $comments,
                'parent' => $comment->id,
                'user' => $user,
                'authorId' => $authorId,
            ]) ?>
        <?php endif; ?>

    <?php endforeach; ?>
<?php endif;
