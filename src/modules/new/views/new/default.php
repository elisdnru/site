<?php $this->renderPartial('_head', array('model'=>$model)); ?>

<article class="entry">

<?php if($this->beginCache(__FILE__.__LINE__.'_newpage_'.$model->id, array('dependency'=>new Tags('new')))) { ?>
    <header>
    <h1><?php echo CHtml::encode($model->title); ?></h1>

    <?php if ($model->image && $model->image_show) : ?>

    <p class="thumb"><a class="lightbox" href="<?php echo $model->imageUrl; ?>">
        <?php echo CHtml::image($model->imageThumbUrl, $model->image_alt); ?>
    </a></p>

    <?php endif; ?>

    <div class="info">
        <p class="date"><span><time datetime="<?php echo date('Y-m-d', strtotime($model->date)); ?>" pubdate="pubdate"><?php echo DDateHelper::normdate($model->date); ?></time></span></p>
        <p class="category"><span><a href="<?php echo $model->page->url; ?>"><?php echo CHtml::encode($model->page->title); ?></a></span></p>
    </div>
    </header>
<?php $this->endCache(); } ?>

    <div class="text">
        <?php echo $this->decodeWidgets(trim($model->text_purified)); ?>
    </div>

    <div class="clear"></div>

<?php if($this->beginCache(__FILE__.__LINE__.'_newpage_'.$model->id, array('dependency'=>new Tags('newsgallery')))) { ?>

    <?php $this->widget('newsgallery.widgets.NewsGalleryWidget', array(
        'id'=>$model->gallery_id,
    )); ?>

    <?php foreach ($model->files as $file) : ?>

        <p>
            <img src="<?php echo Yii::app()->request->baseUrl; ?>/images/fileicon.jpg" alt="" />
            <a href="<?php echo Yii::app()->request->baseUrl . '/' . NewsFile::FILE_PATH . '/' . $file->file; ?>"><?php echo str_replace('_', ' ', $file->title); ?></a>
        </p>

    <?php endforeach; ?>

<?php $this->endCache(); } ?>

</article>

<aside>

<?php $this->widget('share.widgets.ShareWidget', array(
    'title'=>$model->title,
    'description'=>$model->description,
    'image'=>$model->imageUrl,
)); ?>

<!-- Другие новости -->
<div class="other_news">
<?php if($this->beginCache(__FILE__.__LINE__.'_newpage_other_'.$model->id, array('dependency'=>new Tags('new')))) { ?>

    <?php $this->widget('new.widgets.ThemeNewsWidget', array(
        'current'=>$model->id,
        'group'=>$model->group_id,
    )); ?>

    <?php $this->widget('new.widgets.OtherNewsWidget', array(
        'page'=>$model->page->path,
        'skip'=>$model->id,
    )); ?>

<?php $this->endCache(); } ?>
</div>
<!-- /Другие новости -->

</aside>

<?php $this->widget('comment.widgets.CommentsWidget', array(
    'material_id'=>$model->id,
    'type'=>NewsComment::TYPE_OF_COMMENT,
    'url'=>$model->url,
)); ?>