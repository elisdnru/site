<?php
/** @var $title string */
/** @var $description string */
/** @var $image string */
/** @var $url string */

use yii\helpers\Html;
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
        'name' => 'Facebook',
        'class' => 'fb',
        'url' => 'https://www.facebook.com/sharer/sharer.php?' .
            http_build_query([
                'u' => $url,
                't' => $title,
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
        <a rel="nofollow noopener" href="<?= Html::encode($provider['url']) ?>"><span class="share-<?= $provider['class'] ?>"></span></a>
    <?php endforeach; ?>
</div>
