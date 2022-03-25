<?php declare(strict_types=1);

use yii\helpers\Html;

/**
 * @var string $title
 * @var string $description
 * @var string $image
 * @var string $url
 */
?>
<?php
$providers = [
    [
        'name' => 'ВКонтакте',
        'class' => 'vk',
        'url' => 'https://vk.com/share.php?' .
            http_build_query([
                'url' => $url,
                'title' => $title,
                'description' => $description,
                'image' => $image,
            ]),
    ],
    [
        'name' => 'Twitter',
        'class' => 'tw',
        'url' => 'http://twitter.com/share?' .
            http_build_query([
                'url' => $url,
                'text' => $title,
            ]),
    ],
];
?>

<div id="share" class="share">
    <?php foreach ($providers as $provider) : ?>
        <a rel="nofollow noopener" href="<?= Html::encode($provider['url']); ?>"><span class="share-<?= $provider['class']; ?>"></span></a>
    <?php endforeach; ?>
</div>
