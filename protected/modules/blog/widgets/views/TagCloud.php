<p id="tag_cloud" class="nomargin center tags"></p>

<script>
	<?php
	$items = array();
	foreach($tags as $tag)
	{
		$size = (int)$tag->frequency + 8;
		if ($size < 8) $size = 9;
		if ($size > 16) $size = 16;

		$items[] = json_encode(array(
			'title' => CHtml::encode($tag->title),
			'url' => $tag->url,
			'frequency' => (int)$tag->frequency,
		));
	}
	?>
	var tags = [<?php echo implode(',', $items); ?>];
	var cloud = jQuery('#tag_cloud');
	var links = jQuery('<span>');
	jQuery.each(tags, function(i, t) {
		var a = jQuery('<a>');
		var size = t.frequency + 8;
		if (size < 8) size = 9;
		if (size > 16) size = 16;
		a.attr('href', t.url);
		a.css('font-size', size + 'pt');
		a.html(t.title);
		links.append(a);
		links.append(' ');
	});
	cloud.append(links);
</script>



