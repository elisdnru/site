<?php declare(strict_types=1);

use Webmozart\Assert\Assert;
use yii\helpers\Html;
use yii\web\Application;

/**
 * @var string $display
 * @var string $fields
 * @var string $providers
 * @var string $hidden
 * @var string $redirect
 */
?>
<?php if (Assert::isInstanceOf(Yii::$app, Application::class)->user->isGuest): ?>
    <div id="uLogin" data-ulogin="display=<?= Html::encode($display); ?>;fields=<?= Html::encode($fields); ?>;providers=<?= Html::encode($providers); ?>;hidden=<?= Html::encode($hidden); ?>;redirect_uri=<?= Html::encode(urlencode($redirect)); ?>"></div>
<?php endif; ?>
