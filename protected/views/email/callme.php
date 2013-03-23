<p>Новый заказ звонка на сайте http://<?php echo $_SERVER['SERVER_NAME']; ?></p>

<p>
    <b>Имя:</b> <?php echo CHtml::encode($callme->name); ?><br />
    <b>Телефон:</b> <?php echo CHtml::encode($callme->tel); ?><br />
</p>

<p>
    ---<br />
    <?php echo nl2br(CHtml::encode($callme->text)); ?>
    <br />---
</p>