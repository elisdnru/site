<?php
$enc_url = urlencode($url);
$enc_title = urlencode($title);
$enc_desc = urlencode($description);
$enc_image = urlencode($image);
?>

<div id="share" class="share"></div>

<script>
<?php ob_start() ?>

(function() {
    var blocks = [
        {name: 'ВКонтакте', class: 'vk', url: 'https://vk.com/share.php?url=<?php echo $enc_url; ?>&title=<?php echo $enc_title; ?>&description=<?php echo $enc_desc; ?>&image=<?php echo $enc_image; ?>'},
        {name: 'Facebook', class: 'fb', url: 'https://www.facebook.com/sharer/sharer.php?u=<?php echo $enc_url; ?>&t=<?php echo $enc_title; ?>'},
        {name: 'Twitter', class: 'tw', url: 'http://twitter.com/share?text=<?php echo $enc_title; ?>:&url=<?php echo $enc_url; ?>'}
    ];
    var share = document.querySelector('#share');
    blocks.forEach(function (block) {
        var a = document.createElement('a');
        a.rel = 'nofollow';
        a.href = block.url;
        a.title = block.name;
        a.addEventListener('click', function (event) {
            var a = event.target.parentNode;
            var url = a.href;
            window.open(url, a.title, 'width=640, height=480');
            event.preventDefault();
        });

        var span = document.createElement('span');
        span.classList.add('share-' + block.class);
        a.appendChild(span);

        share.appendChild(a);
    });
})();

<?php Yii::app()->clientScript->registerScript(__FILE__ . __LINE__, ob_get_clean(), CClientScript::POS_END); ?>
</script>
