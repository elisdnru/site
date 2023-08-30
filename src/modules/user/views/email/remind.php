<?php declare(strict_types=1);

use yii\helpers\Html;

/**
 * @var string $password
 */
$request = Yii::$app->request;
?>
<p>Запрошен сброс пароля на сайте <?= $request->getHostInfo(); ?></p>

<p>Временный пароль: <b><?= Html::encode($password); ?></b></p>

<p>Войдите на сайт и смените пароль в кабинете.</p>
