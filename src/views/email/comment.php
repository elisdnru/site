<?php
/** @var $comment Comment */
/** @var $current Comment */

use app\modules\comment\models\Comment;
use yii\helpers\Html; ?>
<?php
$url = 'http://' . $_SERVER['SERVER_NAME'] . $comment->material->getUrl();
?>

<p>
    На ваш комментарий к статье
    &laquo;<a href="<?= $url ?>"><?= $comment->material->title ?></a>&raquo;
    кто-то написал ответ:
</p>

<p>
    ------<br />
    <?= nl2br(mb_substr(Html::encode($current->text), 0, 50, 'UTF-8')) ?>...
    <br />------
</p>

<p>Прочитать полностью его можно <a href="<?= $url ?>#comment_<?= $comment->id ?>">здесь</a>.</p>
