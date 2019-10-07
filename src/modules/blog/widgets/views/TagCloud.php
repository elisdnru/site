<?php
$items = [];
foreach ($tags as $tag) {
    $size = (int)$tag->frequency + 8;
    if ($size < 8) {
        $size = 9;
    }
    if ($size > 16) {
        $size = 16;
    }

    $items[] = [
        'title' => CHtml::encode($tag->title),
        'url' => $tag->url,
        'frequency' => (int)$tag->frequency,
    ];
}
?>

<div id="tag_cloud" class="tags" data-tags="<?php echo CHtml::encode(json_encode($items, JSON_UNESCAPED_UNICODE)); ?>"></div>

