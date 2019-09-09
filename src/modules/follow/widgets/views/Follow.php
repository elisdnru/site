<p id="followMe" class="follow center"></p>

<script>
    /*<![CDATA[*/
    jQuery('#followMe').follow({
        rss: 'http://feeds.feedburner.com/elisdn',
        twitter: 'elisdnru',
        livejournal: 'elisdn',
        github: 'ElisDN',
        assets_url: '<?php echo $assetsUrl; ?>'
    });
    /*]]>*/
</script>

<?php $this->widget('block.widgets.BlockWidget', ['id' => 'subscribe_sidebar']); ?>

