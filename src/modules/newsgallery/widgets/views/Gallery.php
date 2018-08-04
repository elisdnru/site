<?php
$dir = Yii::app()->file->set($path);
?>
<?php if ($dir->contents): ?>

<?php
    $cs = Yii::app()->getClientScript();
    $cs->registerCoreScript('jquery');
    $url = CHtml::asset(Yii::getPathOfAlias('newsgallery.widgets.views.assets'));
    $cs->registerCssFile($url . '/fotorama.css');
    $cs->registerScriptFile($url . '/fotorama.js', CClientScript::POS_HEAD);
?>

<div id="fotorama">

<?php foreach ($dir->contents as $item) : ?>

    <?php $file = Yii::app()->file->set($item); ?>
    <?php if (!preg_match('|_prev\\.|', $file->basename, $t)): ?>
        <?php
        $orig = $path.'/'.$file->basename;
        $origuri = $htmlpath.'/'.$file->basename;
        $prev = $path.'/'.$file->filename.'_prev.'.$file->extension;
        $prevuri = $htmlpath.'/'.$file->filename.'_prev.'.$file->extension;
        ?>
        <a href="/<?php echo $origuri; ?>">
            <img src="/<?php echo file_exists($prev) ? $prevuri : $origuri; ?>" alt="" />
        </a>
    <?php endif; ?>

<?php endforeach; ?>

</div>

<script type="text/javascript">
    $(function() {
        $('#fotorama').fotorama({
            data: null,
            width: '100%',
            height: 470
        });
    });
</script>
<?php endif; ?>