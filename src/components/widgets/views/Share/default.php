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

<div id="share" class="share" data-providers="<?php echo CHtml::encode(json_encode($providers, JSON_UNESCAPED_UNICODE)); ?>"></div>
