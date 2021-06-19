<?php declare(strict_types=1);

use app\modules\comment\models\Comment;
use yii\helpers\Html;
use yii\helpers\Url;

/**
 * @var Comment $comment
 * @var Comment $current
 */
?>
<?php
$url = Url::to($comment->material->getCommentUrl(), true);
?>

<p>
    На ваш комментарий к статье
    &laquo;<a href="<?= $url; ?>"><?= $comment->material->getCommentTitle(); ?></a>&raquo;
    кто-то написал ответ:
</p>

<p>
    ------<br />
    <?= nl2br(mb_substr(Html::encode($current->text), 0, 50, 'UTF-8')); ?>...
    <br />------
</p>

<p>Прочитать полностью его можно <a href="<?= $url; ?>#comment_<?= $comment->id; ?>">здесь</a>.</p>
