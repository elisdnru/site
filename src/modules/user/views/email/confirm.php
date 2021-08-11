<?php declare(strict_types=1);

use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\Request;

/**
 * @var string $code
 * @var Request $request
 */
$request = Yii::$app->request;

$confirmUrl = Url::to(['/user/registration/confirm', 'code' => $code], true);
?>

<p>Здравствуйте! Кто-то указал ваш email при регистрации на сайте <?= $request->getHostInfo(); ?></p>

<p>Если это сделали вы сами, то проследуйте по ссылке для подтверждения:</p>

<p><?= Html::a(Html::encode($confirmUrl), $confirmUrl); ?></p>

<p>Если же это сделали не Вы, то просто удалите это письмо.</p>
