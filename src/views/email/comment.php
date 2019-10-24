<?php
/** @var $comment \app\modules\comment\models\Comment */
/** @var $current \app\modules\comment\models\Comment */
?>
<?php
$url = 'http://' . $_SERVER['SERVER_NAME'] . $comment->material->url;
?>

<p>
    На ваш комментарий к статье
    &laquo;<a href="<?= $url ?>"><?= $comment->material->title ?></a>&raquo;
    кто-то написал ответ:
</p>

<p>
    ------<br />
    <?= nl2br(mb_substr(CHtml::encode($current->text), 0, 50, 'UTF-8')) ?>...
    <br />------
</p>

<p>Прочитать полностью его можно <a href="<?= $url ?>#comment_<?= $comment->id ?>">здесь</a>.</p>
