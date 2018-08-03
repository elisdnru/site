
<p id="followMe" class="follow center"></p>

<script type="text/javascript">
	/*<![CDATA[*/
	jQuery('#followMe').follow({
		rss: '<?php echo Yii::app()->config->get('GENERAL.FEED_URL'); ?>',
		twitter: '<?php echo Yii::app()->config->get('FOLLOW.TWITTER'); ?>',
		livejournal: '<?php echo Yii::app()->config->get('FOLLOW.LIVEJOURNAL'); ?>',
		github: '<?php echo Yii::app()->config->get('FOLLOW.GITHUB'); ?>',
		assets_url: '<?php echo $assetsUrl; ?>'
	});
	/*]]>*/
</script>

<?php $this->widget('block.widgets.BlockWidget', array('id'=>'subscribe_sidebar'));?>

