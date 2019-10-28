<?php
/** @var $contact Contact */

use yii\helpers\Html;
?>
<p>Новое сообщение в обратную связь на сайте <?= Yii::$app->request->getHostInfo() ?></p>

<p>
    <b>Имя:</b> <?= Html::encode($contact->name) ?><br />
    <b>Email:</b> <?= Html::encode($contact->email) ?><br />
    <b>Телефон:</b> <?= Html::encode($contact->phone) ?><br />
</p>

<p>
    ---<br />
    <?= nl2br(Html::encode($contact->text)) ?>
    <br />---
</p>
