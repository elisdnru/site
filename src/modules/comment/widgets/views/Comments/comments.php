<?php declare(strict_types=1);

use app\modules\comment\forms\CommentForm;
use app\modules\comment\models\Comment;
use app\modules\user\models\User;
use yii\web\Session;
use yii\web\View;

/**
 * @var View $this
 * @var Comment[] $comments
 * @var User $user
 * @var CommentForm $form
 * @var int $authorId
 * @var Session $session
 */
?>
<div id="comments">

    <div class="block-title">Комментарии</div>

    <div>
        <?= $this->render('_tree', [
            'indent' => 0,
            'comments' => $comments,
            'parent' => 0,
            'user' => $user,
            'authorId' => $authorId,
            'session' => $session,
        ]); ?>
    </div>

    <?php if (count($comments)): ?>
        <p class="reply-comment"><a href="#comment-form">Оставить комментарий</a></p>
    <?php endif; ?>

    <?= $this->render('_form', [
        'form' => $form,
        'user' => $user,
    ]); ?>

</div>
