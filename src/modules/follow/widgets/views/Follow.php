<p id="followMe" class="follow center"></p>

<script>
    /*<![CDATA[*/
    jQuery('#followMe').follow({
        assets_url: '<?php echo $assetsUrl; ?>'
    });
    /*]]>*/
</script>

<?php $this->widget('block.widgets.BlockWidget', ['id' => 'subscribe_sidebar']); ?>

