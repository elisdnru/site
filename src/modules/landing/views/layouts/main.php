<?php declare(strict_types=1);

use app\modules\user\models\Access;
use app\widgets\Counters;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;

/**
 * @var View $this
 * @var string $content
 */
$this->registerLinkTag(['rel' => 'canonical', 'href' => Url::canonical()]);

?>
<?php $this->beginPage(); ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language; ?>">
<head>
    <?php if (!Yii::$app->user->can(Access::ROLE_ADMIN)): ?>
        <script src="//elisdn.justclick.ru/jsapi/click.js" async></script>
    <?php endif; ?>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />

    <?= isset($this->blocks['meta']) ? (string)$this->blocks['meta'] : ''; ?>

    <link rel="shortcut icon" href="/favicon.ico">

    <?php $this->head(); ?>

    <?= isset($this->blocks['styles']) ? (string)$this->blocks['styles'] : ''; ?>

    <title><?= Html::encode($this->title); ?></title>
</head>
<body>
<?php $this->beginBody(); ?>

<?= $content; ?>

<?= Counters::widget(); ?>

<?php $this->endBody(); ?>

</body>
</html>
<?php $this->endPage(); ?>
