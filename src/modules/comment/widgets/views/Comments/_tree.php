<?php

use app\modules\user\models\User;

/**
 * @var Comment $comments
 * @var int $parent
 * @var int $indent
 * @var int $authorId
 * @var User $user
 */

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
