<?php declare(strict_types=1);

use app\modules\user\models\Access;
use Webmozart\Assert\Assert;
use yii\helpers\Html;
use yii\web\Application;
use yii\web\View;

/**
 * @var View $this
 * @var string $name
 * @var string $message
 * @var array $error
 * @psalm-var array{code?: int} $error
 * @var Exception $exception
 */
$this->title = 'Ошибка';
$this->params['breadcrumbs'] = [
    'Ошибка ' . ($error['code'] ?? ''),
];
?>

<?php if (Assert::isInstanceOf(Yii::$app, Application::class)->user->can(Access::CONTROL)) {
    $this->params['admin'][] = ['label' => 'Вернуться на сайт', 'url' => ['default/index']];
} ?>

<h2><?= $name; ?></h2>

<?php if ($message): ?>
    <div class="flash flash-error">
        <?= nl2br(Html::encode($message)); ?>
    </div>
<?php endif; ?>

<p>Так получилось...</p>
<p><a href="/">На главную</a></p>
