<?php $this->renderPartial('_head', ['model' => $model]); ?>

    <article class="entry">

        <?php if ($this->beginCache(__FILE__ . __LINE__ . '_newpage_' . $model->id, ['dependency' => new Tags('new')])) : ?>
            <h1><?php echo CHtml::encode($model->title); ?></h1>
            <?php $this->endCache(); ?>
        <?php endif; ?>

        <div class="text">
            <?php echo $this->decodeWidgets(trim($model->text_purified)); ?>
        </div>

        <div class="clear"></div>

        <?php if ($this->beginCache(__FILE__ . __LINE__ . '_newpage_' . $model->id, ['dependency' => new Tags('new')])) : ?>
            <?php $this->widget('newsgallery.widgets.NewsGalleryWidget', [
                'id' => $model->gallery_id,
            ]); ?>

            <?php foreach ($model->files as $file) : ?>
                <p><img src="<?php echo Yii::app()->baseUrl; ?>/images/fileicon.jpg" alt=""/>
                    <a href="<?php echo Yii::app()->request->baseUrl . '/' . NewsFile::FILE_PATH . '/' . $file->file; ?>"><?php echo str_replace('_', ' ', $file->title); ?></a>
                </p>

            <?php endforeach; ?>

            <?php $this->endCache(); ?>
        <?php endif; ?>

    </article>

<?php $this->widget('share.widgets.ShareWidget', [
    'title' => $model->title,
    'description' => $model->description,
    'image' => $model->imageUrl,
]); ?>