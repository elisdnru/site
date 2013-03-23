<?php
$assetsUrl = CHtml::asset(Yii::getPathOfAlias('share.assets'));
Yii::app()->clientScript->registerCssFile($assetsUrl . '/share.css');
Yii::app()->clientScript->registerScriptFile($assetsUrl . '/socials.js');
?>

<p class="share">
    <a rel="nofollow" onclick="window.open('http://vkontakte.ru/share.php?url=<?php echo $url; ?>&amp;title=<?php echo $title; ?>&amp;description=<?php echo $description; ?>&amp;image=<?php echo $image; ?>', 'vkontakte', 'width=626, height=436'); return false;" href="http://vkontakte.ru/share.php?url=<?php echo $url; ?>&amp;title=<?php echo $title; ?>&amp;description=<?php echo $description; ?>&amp;image=<?php echo $image; ?>" title="vkontakte.ru"><span style="background-image:url('<?php echo $assetsUrl; ?>/32/vkontakte.png');"></span></a>
    <a rel="nofollow" onclick="window.open('http://twitter.com/home/?status=<?php echo $url; ?>', 'tw', 'width=640, height=480'); return false;" href="http://twitter.com/home/?status=<?php echo $url; ?>" title="twitter.com"><span style="background-image:url('<?php echo $assetsUrl; ?>/32/twitter.png');"></span></a>
    <a rel="nofollow" onclick="window.open('http://www.facebook.com/sharer.php?u=<?php echo $url; ?>&amp;t=<?php echo $title; ?>', 'facebook', 'width=626, height=436'); return false;" href="http://www.facebook.com/share.php?u=<?php echo $url; ?>&amp;t=<?php echo $title; ?>" title="facebook.com"><span style="background-image:url('<?php echo $assetsUrl; ?>/32/facebook.png');"></span></a>
    <a rel="nofollow" onclick="window.open('http://www.odnoklassniki.ru/dk?st.cmd=addShare&amp;st.s=1&amp;st._surl=<?php echo $url; ?>', 'odkl', 'width=626, height=436'); return false;" href="http://www.odnoklassniki.ru/dk?st.cmd=addShare&amp;st.s=1&amp;st._surl=<?php echo $url; ?>" title="odnoklassniki.ru"><span style="background-image:url('<?php echo $assetsUrl; ?>/32/odnoklassniki.png');"></span></a>
    <a rel="nofollow" onclick="window.open('http://wow.ya.ru/posts_share_link.xml?url=<?php echo $url; ?>&amp;title=<?php echo $title; ?>&amp;body=<?php echo $description; ?>', 'yaru', 'width=626, height=436'); return false;" href="http://my.ya.ru/posts_add_link.xml?url=<?php echo $url; ?>&amp;title=<?php echo $title; ?>&amp;body=<?php echo $title; ?>" title="ya.ru"><span style="background-image:url('<?php echo $assetsUrl; ?>/32/yandex.png');"></span></a>
    <a rel="nofollow" onclick="window.open('http://www.livejournal.com/update.bml?event=<?php echo $description; ?><?php echo urlencode('<br />'); ?><?php echo $url; ?>&amp;subject=<?php echo $title; ?>&amp;body=<?php echo $description; ?>', 'lj', 'width=800, height=600'); return false;" href="http://www.livejournal.com/update.bml?event=<?php echo $description; ?><?php echo urlencode('<br />'); ?><?php echo $url; ?>&amp;subject=<?php echo $title; ?>&amp;body=<?php echo $description; ?>" title="livejournal.com"><span style="background-image:url('<?php echo $assetsUrl; ?>/32/livejournal.png');"></span></a>
    <a rel="nofollow" onclick="window.open('https://plus.google.com/share?url=?<?php echo $url; ?>', 'gplus', 'width=800, height=600'); return false;" href="https://plus.google.com/share?url=?<?php echo $url; ?>" title="Google+"><span style="background-image:url('<?php echo $assetsUrl; ?>/32/googleplus.png');"></span></a>
</p>

<div class="like_box">
    <div class="item vk">
        <div id="vk_like"></div>
    </div>
    <div class="item fb">
        <div class="fb-like" data-send="false" data-layout="button_count" data-width="150" data-show-faces="false"></div>
    </div>
    <div class="item tw">
        <a href="https://twitter.com/share" class="twitter-share-button" data-lang="ru">Твитнуть</a>
    </div>
    <div class="item gp">
        <g:plus action="share" annotation="bubble"></g:plus>
    </div>
</div>


