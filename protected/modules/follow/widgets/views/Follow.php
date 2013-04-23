<p class="follow center">
    <a rel="nofollow" href="<?php echo Yii::app()->config->get('GENERAL.FEED_URL'); ?>" title="RSS"><span style="background-image:url('<?php echo $assetsUrl; ?>/32/feed.png');"></span></a>
    <?php if ($username = Yii::app()->config->get('FOLLOW.TWITTER')): ?><a rel="nofollow" href="http://twitter.com/<?php echo $username; ?>" title="Twitter"><span style="background-image:url('<?php echo $assetsUrl; ?>/32/twitter.png');"></span></a><?php endif; ?>
    <?php if ($username = Yii::app()->config->get('FOLLOW.LIVEJOURNAL')): ?><a rel="nofollow" href="http://<?php echo $username; ?>.livejournal.com" title="LiveJournal"><span style="background-image:url('<?php echo $assetsUrl; ?>/32/livejournal.png');"></span></a><?php endif; ?>
    <?php if ($username = Yii::app()->config->get('FOLLOW.GITHUB')): ?><a rel="nofollow" href="https://github.com/<?php echo $username; ?>" title="GitHub"><span style="background-image:url('<?php echo $assetsUrl; ?>/32/github.png');"></span></a><?php endif; ?>
</p>

<?php if ($username = Yii::app()->config->get('FOLLOW.FEEDBURNER')): ?>
<div class="form">
	<form action="http://feedburner.google.com/fb/a/mailverify" method="post" target="popupwindow" onsubmit="window.open('http://feedburner.google.com/fb/a/mailverify?uri=<?php echo $username; ?>', 'popupwindow', 'scrollbars=yes,width=550,height=520');return true">
		<input type="hidden" name="uri" value="<?php echo $username; ?>" />
		<input type="hidden" name="loc" value="ru_RU" />
		<div class="row center"><label>Введите ваш Email</label><input type="text" name="email" style="width:80%" /></div>
		<div class="row buttons center"><input type="submit" value="Подписаться на новости" /></div>
	</form>
</div>
<?php endif; ?>