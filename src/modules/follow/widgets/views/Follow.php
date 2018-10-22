<p id="followMe" class="follow center"></p>

<script type="text/javascript">
    /*<![CDATA[*/
    jQuery('#followMe').follow({
        rss: '<?php echo Yii::app()->params['GENERAL.FEED_URL']; ?>',
        twitter: '<?php echo Yii::app()->params['FOLLOW.TWITTER']; ?>',
        livejournal: '<?php echo Yii::app()->params['FOLLOW.LIVEJOURNAL']; ?>',
        github: '<?php echo Yii::app()->params['FOLLOW.GITHUB']; ?>',
        assets_url: '<?php echo $assetsUrl; ?>'
    });
    /*]]>*/
</script>

<?php $this->widget('block.widgets.BlockWidget', ['id' => 'subscribe_sidebar']); ?>

