<?php
/** @var $confirmUrl string */
use yii\helpers\Html;
?>
<p>Для подтверждения регистрации на сайте <?= Yii::app()->request->getHostInfo() ?> проследуйте по ссылке:</p>

<p><?php echo CHtml::link(Html::encode($confirmUrl), $confirmUrl); ?></p>
