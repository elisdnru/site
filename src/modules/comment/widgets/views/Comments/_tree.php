<?php
/** @var $comments Comment */
/** @var $parent int */
/** @var $indent int */
/** @var $authorId int */
/** @var $user User */
?>
<?php if (isset($comments[$parent])) : ?>
    <?php foreach ($comments[$parent] as $comment) : ?>
        <?= $this->render('_comment', [
            'indent' => $indent,
            'comment' => $comment,
            'authorId' => $authorId,
            'user' => $user,
        ]) ?>

        <?php if ($indent < 100 && isset($comments[$comment->id]) && $comments[$comment->id]) : ?>
            <?= $this->render('_tree', [
                'indent' => $indent + 1,
                'comments' => $comments,
                'parent' => $comment->id,
                'user' => $user,
                'authorId' => $authorId,
            ]) ?>
        <?php endif; ?>

    <?php endforeach; ?>
<?php endif;
