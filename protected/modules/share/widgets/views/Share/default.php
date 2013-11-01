<?php
$assetsUrl = CHtml::asset(Yii::getPathOfAlias('share.assets'));
Yii::app()->clientScript->registerCssFile($assetsUrl . '/share.css');
Yii::app()->clientScript->registerScriptFile($assetsUrl . '/socials.js');

$enc_url = urlencode($url);
$enc_title = urlencode($title);
$enc_desc = urlencode($description);
$enc_image = urlencode($image);

$tw_status = urldecode($title . ': ' . $url);
?>

<p class="share">
    <a rel="nofollow" onclick="window.open('http://vkontakte.ru/share.php?url=<?php echo $enc_url; ?>&amp;title=<?php echo $enc_title; ?>&amp;description=<?php echo $enc_desc; ?>&amp;image=<?php echo $enc_image; ?>', 'vkontakte', 'width=626, height=436'); return false;" href="http://vkontakte.ru/share.php?url=<?php echo $enc_url; ?>&amp;title=<?php echo $enc_title; ?>&amp;description=<?php echo $enc_desc; ?>&amp;image=<?php echo $enc_image; ?>" title="vkontakte.ru"><span style="background-image:url('<?php echo $assetsUrl; ?>/32/vkontakte.png');"></span></a>
    <a rel="nofollow" onclick="window.open('http://twitter.com/home/?status=<?php echo $tw_status; ?>', 'tw', 'width=640, height=480'); return false;" href="http://twitter.com/home/?status=<?php echo $tw_status; ?>" title="twitter.com"><span style="background-image:url('<?php echo $assetsUrl; ?>/32/twitter.png');"></span></a>
    <a rel="nofollow" onclick="window.open('http://www.facebook.com/sharer.php?u=<?php echo $enc_url; ?>&amp;t=<?php echo $enc_title; ?>', 'facebook', 'width=626, height=436'); return false;" href="http://www.facebook.com/share.php?u=<?php echo $enc_url; ?>&amp;t=<?php echo $enc_title; ?>" title="facebook.com"><span style="background-image:url('<?php echo $assetsUrl; ?>/32/facebook.png');"></span></a>
    <a rel="nofollow" onclick="window.open('http://www.odnoklassniki.ru/dk?st.cmd=addShare&amp;st.s=1&amp;st._surl=<?php echo $enc_url; ?>', 'odkl', 'width=626, height=436'); return false;" href="http://www.odnoklassniki.ru/dk?st.cmd=addShare&amp;st.s=1&amp;st._surl=<?php echo $enc_url; ?>" title="odnoklassniki.ru"><span style="background-image:url('<?php echo $assetsUrl; ?>/32/odnoklassniki.png');"></span></a>
    <a rel="nofollow" onclick="window.open('http://wow.ya.ru/posts_share_link.xml?url=<?php echo $enc_url; ?>&amp;title=<?php echo $enc_title; ?>&amp;body=<?php echo $enc_desc; ?>', 'yaru', 'width=626, height=436'); return false;" href="http://my.ya.ru/posts_add_link.xml?url=<?php echo $enc_url; ?>&amp;title=<?php echo $enc_title; ?>&amp;body=<?php echo $enc_title; ?>" title="ya.ru"><span style="background-image:url('<?php echo $assetsUrl; ?>/32/yandex.png');"></span></a>
    <a rel="nofollow" onclick="window.open('http://www.livejournal.com/update.bml?event=<?php echo $enc_desc; ?><?php echo urlencode('<br />'); ?><?php echo $enc_url; ?>&amp;subject=<?php echo $enc_title; ?>&amp;body=<?php echo $enc_desc; ?>', 'lj', 'width=800, height=600'); return false;" href="http://www.livejournal.com/update.bml?event=<?php echo $enc_desc; ?><?php echo urlencode('<br />'); ?><?php echo $enc_url; ?>&amp;subject=<?php echo $enc_title; ?>&amp;body=<?php echo $enc_desc; ?>" title="livejournal.com"><span style="background-image:url('<?php echo $assetsUrl; ?>/32/livejournal.png');"></span></a>
    <a rel="nofollow" onclick="window.open('https://plus.google.com/share?url=?<?php echo $enc_url; ?>', 'gplus', 'width=800, height=600'); return false;" href="https://plus.google.com/share?url=?<?php echo $enc_url; ?>" title="Google+"><span style="background-image:url('<?php echo $assetsUrl; ?>/32/googleplus.png');"></span></a>
</p>

<div class="like_box">
    <div class="item vk">
        <div id="vk_like"></div>
    </div>
    <div class="item fb">
        <div class="fb-like" data-send="false" data-layout="button_count" data-width="150" data-show-faces="false"></div>
    </div>
    <div class="item tw">
        <a rel="nofollow" href="https://twitter.com/share" class="twitter-share-button" data-lang="ru">Твитнуть</a>
    </div>
    <div class="item gp">
        <g:plus action="share" annotation="bubble"></g:plus>
    </div>
</div>


