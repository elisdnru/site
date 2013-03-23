<?php
$url = 'http://' . $_SERVER['SERVER_NAME'] . $comment->material->url;
?>

<p style="font-family:arial; font-size:12px">Здравствуйте!</p>

<p style="font-family:arial; font-size:12px">В ветке вашего комментария к статье &laquo;<a href="<?php echo $url; ?>"><?php echo $comment->material->title; ?></a>&raquo; кто-то написал ответ:</p>

<p style="font-family:arial; font-size:12px">------<br />
    <?php echo nl2br(mb_substr(CHtml::encode($current->text), 0, 50, 'UTF-8')); ?>...
<br />------</p>

<p style="font-family:arial; font-size:12px">Прочитать полностью его можно <a href="<?php echo $url; ?>#comment_<?php echo $comment->id; ?>">здесь</a>.</p>
