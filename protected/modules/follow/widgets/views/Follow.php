<p class="follow center">
    <a href="<?php echo Yii::app()->config->get('GENERAL.FEED_URL'); ?>" title="RSS"><span style="background-image:url('<?php echo $assetsUrl; ?>/32/feed.png');"></span></a>
    <a href="http://twitter.com/elisdnru" title="Twitter"><span style="background-image:url('<?php echo $assetsUrl; ?>/32/twitter.png');"></span></a>
    <a href="http://elisdn.livejournal.com" title="LiveJournal"><span style="background-image:url('<?php echo $assetsUrl; ?>/32/livejournal.png');"></span></a>
    <a href="https://github.com/ElisDN" title="GitHub"><span style="background-image:url('<?php echo $assetsUrl; ?>/32/github.png');"></span></a>
</p>

<div class="form">
	<form action="http://feedburner.google.com/fb/a/mailverify" method="post" target="popupwindow" onsubmit="window.open('http://feedburner.google.com/fb/a/mailverify?uri=elisdn', 'popupwindow', 'scrollbars=yes,width=550,height=520');return true">
		<input type="hidden" name="uri" value="elisdn" />
		<input type="hidden" name="loc" value="ru_RU" />
		<div class="row center"><label>Введите ваш Email</label><input type="text" name="email" style="width:80%" /></div>
		<div class="row buttons center"><input type="submit" value="Подписаться на новости" /></div>
	</form>
</div>
