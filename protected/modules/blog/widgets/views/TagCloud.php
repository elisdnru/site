<!--noindex-->
<p class="nomargin center tags">
<?php

foreach($tags as $tag)
{
    $size = (int)$tag->frequency + 8;

    if ($size < 8) $size = 9;
    if ($size > 16) $size = 16;
    echo CHtml::link(CHtml::encode($tag->title), $tag->url ,array(
		'rel'=>'nofollow',
        'style'=>'font-size:' . $size . 'pt',
    )) . "\n";
}
?>

</p>
<!--/noindex-->

