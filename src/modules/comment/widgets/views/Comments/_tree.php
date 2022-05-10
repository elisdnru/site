<?php declare(strict_types=1);

use app\modules\comment\models\Comment;
use app\modules\user\models\User;
use yii\web\Session;
use yii\web\View;

/**
 * @var View $this
 * @var Comment[][] $comments
 * @var int $parent
 * @var int $indent
 * @var int $authorId
 * @var User $user
 * @var Session $session
 */
?>
<?php if (isset($comments[$parent])) : ?>
    <?php foreach ($comments[$parent] as $comment) : ?>
        <?= $this->render('_comment', [
            'indent' => $indent,
            'comment' => $comment,
            'authorId' => $authorId,
            'user' => $user,
            'session' => $session,
        ]); ?>

        <?php if ($indent < 100 && array_key_exists($comment->id, $comments)) : ?>
            <?= $this->render('_tree', [
                'indent' => $indent + 1,
                'comments' => $comments,
                'parent' => $comment->id,
                'user' => $user,
                'authorId' => $authorId,
                'session' => $session,
            ]); ?>
        <?php endif; ?>

    <?php endforeach; ?>
<?php endif;
