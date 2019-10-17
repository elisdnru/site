<?php
/** @var $user \app\modules\user\models\User */
use yii\helpers\Html;
?>
<p>Запрошен сброс пароля на сайте <?= Yii::app()->request->getHostInfo() ?>.</p>

<p>Временный пароль: <?php echo Html::encode($user->new_password); ?></p>

<p>Войдите на сайт и смените пароль в кабинете.</p>
