<p style="font-family:arial; font-size:12px">Изменились параметры вашей учётной записи на сайте
    http://<?php echo $_SERVER['SERVER_NAME']; ?></p>

<p style="font-family:arial; font-size:12px">Логин: <?php echo CHtml::encode($user->username); ?><br />
    Пароль: <?php echo CHtml::encode($user->new_password); ?></p>
