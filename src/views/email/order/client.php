<p style="font-family:arial; font-size:12px;">Ваш заказ на сайте http://<?php echo $_SERVER['SERVER_NAME']; ?></p>

<p style="font-family:arial; font-size:12px;">Менеджер магазина скоро свяжется с Вами.</p>

<?php echo Yii::app()->controller->renderPartial('application.views.email.order._contentfull', array('order'=>$order), true); ?>