<header>
    <?php $this->renderPartial('_head', array('page'=>$page)); ?>
    <?php $this->renderPartial($layout_subpages, array('page'=>$page)); ?>
</header>

<?php if($this->beginCache(__FILE__.__LINE__.'_page_'.$page->id, array('duration'=>3600))) { ?>

    <?php if ($page->image) : ?>

        <p class="thumb"><a class="lightbox" href="<?php echo $page->imageUrl; ?>">
            <?php echo CHtml::image($page->imageThumbUrl, $page->image_alt, array('class'=>'page')); ?>
        </a></p>

    <?php endif; ?>
<?php $this->endCache(); } ?>

<?php if (Yii::app()->request->getParam('page', 1) > 1): ?><noindex><?php endif; ?>

<div class="text">
    <?php echo $this->decodeWidgets($page->text_purified); ?>
</div>

<?php if (Yii::app()->request->getParam('page', 1) > 1): ?></noindex><?php endif; ?>

<?php if($this->beginCache(__FILE__.__LINE__.'_page_'.$page->id, array('duration'=>3600))) { ?>
    <?php foreach ($page->files as $file) : ?>

        <p><img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/fileicon.jpg" alt="" />
            <a href="<?php echo Yii::app()->request->baseUrl . '/' . PageFile::FILE_PATH . '/' . $file->file; ?>"><?php echo str_replace('_', ' ', $file->title); ?></a>
        </p>

    <?php endforeach; ?>

<?php $this->endCache(); } ?>

<?php if (preg_match('|<pre\sclass=\"brush\s?:\s?\w+\">|', $page->text)): ?>
<?php Yii::app()->syntaxhighlighter->addHighlighter(); ?>
<?php endif; ?>

<?php $this->widget('new.widgets.NewsWidget', array(
    'page'=>$page,
)); ?>