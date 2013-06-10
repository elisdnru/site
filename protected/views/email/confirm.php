<p style="font-family:arial; font-size:12px;">Для подтверждения регистрации на сайте http://<?php echo $_SERVER['SERVER_NAME']; ?> проследуйте по ссылке</p>

<p style="font-family:arial; font-size:12px;"><?php echo CHtml::link(CHtml::encode($confirmUrl), $confirmUrl); ?></p>
