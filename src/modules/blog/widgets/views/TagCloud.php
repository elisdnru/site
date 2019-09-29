<p id="tag_cloud" class="nomargin center tags"></p>

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

<script>
<?php ob_start(); ?>

(function() {
    var tags = <?php echo json_encode($items, JSON_UNESCAPED_UNICODE); ?>;
    var cloud = document.querySelector('#tag_cloud');
    var links = document.createElement('span');
    tags.forEach(function (tag) {
        var a = document.createElement('a');
        var size = tag.frequency + 8;
        if (size < 8) size = 9;
        if (size > 16) size = 16;
        a.href = tag.url;
        a.style['font-size'] = size + 'pt';
        a.innerHTML = tag.title;
        links.append(a);
        links.append(' ');
    })
    cloud.append(links);
})();

<?php Yii::app()->clientScript->registerScript(__FILE__ . __LINE__, ob_get_clean(), CClientScript::POS_END); ?>
</script>



