<?php declare(strict_types=1);

use yii\helpers\Html;

/**
 * @var string $display
 * @var string $url
 */
if (Yii::$app->user->isGuest): ?>
    <?php
    $providers = [
        [
            'name' => 'Google',
            'class' => 'gl',
            'url' => '',
        ],
        [
            'name' => 'MailRu',
            'class' => 'mr',
            'url' => '',
        ],
        [
            'name' => 'Yandex',
            'class' => 'ya',
            'url' => '',
        ],
        [
            'name' => 'ВКонтакте',
            'class' => 'vk',
            'url' => '',
        ],
        [
            'name' => 'Facebook',
            'class' => 'fb',
            'url' => '',
        ],
        [
            'name' => 'Twitter',
            'class' => 'tw',
            'url' => '',
        ],
    ];
    ?>

    <div class="auth <?= $display; ?>">
        <?php foreach ($providers as $provider): ?>
            <span class="auth-<?= $provider['class']; ?>" title="<?= $provider['name']; ?>" data-href="<?= Html::encode($provider['url']); ?>"></span>
        <?php endforeach; ?>
    </div>
<?php endif; ?>
