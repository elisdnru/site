<p id="tag_cloud" class="nomargin center tags"></p>

<script>
<?php ob_start(); ?>

jQuery(function($) {
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
    var tags = <?php echo json_encode($items); ?>;
    var cloud = $('#tag_cloud')
    var links = $('<span>')
    $.each(tags, function (i, t) {
        var a = $('<a>')
        var size = t.frequency + 8
        if (size < 8) size = 9
        if (size > 16) size = 16
        a.attr('href', t.url)
        a.css('font-size', size + 'pt')
        a.html(t.title)
        links.append(a)
        links.append(' ')
    })
    cloud.append(links)
});

<?php Yii::app()->clientScript->registerScript(__FILE__ . __LINE__, ob_get_clean(), CClientScript::POS_END); ?>
</script>



