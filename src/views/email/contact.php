<p>Новое сообщение в обратную связь на сайте http://<?php echo $_SERVER['SERVER_NAME']; ?></p>

<p>
    <b>Имя:</b> <?php echo CHtml::encode($contact->name); ?><br />
    <b>Email:</b> <?php echo CHtml::encode($contact->email); ?><br />
    <b>Телефон:</b> <?php echo CHtml::encode($contact->phone); ?><br />
</p>

<p>
    ---<br />
    <?php echo nl2br(CHtml::encode($contact->text)); ?>
    <br />---
</p>