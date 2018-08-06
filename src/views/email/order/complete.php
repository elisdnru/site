<p style="font-family:arial; font-size:12px;">Здравсвуйте. Ваш заказ № <?php echo CHtml::encode($order->fullId); ?> на
    сайте http://<?php echo $_SERVER['SERVER_NAME']; ?> отмечен отправленным.</p>

<?php echo Yii::app()->controller->renderPartial('application.views.email.order._contentfull', ['order' => $order], true); ?>
