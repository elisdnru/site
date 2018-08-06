<?php
/* @var $this DController */
/* @var $model GalleryPhoto */
/* @var $prev GalleryPhoto */
/* @var $next GalleryPhoto */
/* @var $dataProvider CActiveDataProvider */

$this->pageTitle = $model->pagetitle ? $model->pagetitle : 'Материал #' . $model->id;
$this->description = $model->description ? $model->description : 'Материал #' . $model->id;
$this->keywords = $model->keywords;

$this->breadcrumbs = array(
    'Галерея' => $this->createUrl('/gallery/default/index')
);

if ($model->category)
    $this->breadcrumbs = array_merge($this->breadcrumbs, $model->category->getBreadcrumbs(true));

$this->breadcrumbs[] = $model->title ? $model->title : '#' . $model->id;

if ($this->is(Access::ROLE_CONTROL)) {

    if ($this->moduleAllowed('gallery')) $this->admin[] = array('label' => 'Редактировать', 'url' => $this->createUrl('/gallery/photoAdmin/update', array('id' => $model->id)));
    if ($this->moduleAllowed('gallery')) $this->admin[] = array('label' => 'Материалы', 'url' => $this->createUrl('/gallery/photoAdmin/index'));
    if ($this->moduleAllowed('gallery') && $model->category) $this->admin[] = array('label' => 'Редактировать категорию', 'url' => $this->createUrl('categoryAdmin/update', array('id' => $model->category_id)));
    if ($this->moduleAllowed('comment') && Yii::app()->moduleManager->active('comment'))
        $this->admin[] = array('label' => 'Комментарии (' . $model->comments_new_count . ' ' . DNumberHelper::Plural($model->comments_new_count, array('новый', 'новых', 'новых')) . ')', 'url' => $this->createUrl('/gallery/commentAdmin/index', array('id' => $model->id)));

    $this->info = 'Нажмите «Редактировать» чтобы изменить материал';
}

CTextHighlighter::registerCssFile();

?>

    <a class="gallery-top" name="gallery-top"></a>

<?php $this->widget('colorbox.widgets.ColorboxWidget'); ?>

<?php if (!$model->public): ?>
    <div class="flash-error">Внимание! Новость скрыта от публикации!</div>
<?php endif; ?>

    <article class="entry">

        <?php if ($this->beginCache(__FILE__ . __LINE__ . '_post_' . $model->id, array('dependency' => new Tags('gallery')))) : ?>

            <?php if ($model->title): ?>
                <h1><?php echo CHtml::encode($model->title); ?></h1>
            <?php endif; ?>

            <div class="gallery-display">

                <?php if ($model->video) : ?>

                    <div class="video">
                        <?php $this->widget('application.modules.main.widgets.FlashWidget', array(
                            'width' => 640,
                            'height' => 360,
                            'src' => $model->video
                        )); ?>
                    </div>

                <?php elseif ($model->image) : ?>

                    <div class="photo">
                        <a class="lightbox" href="<?php echo $model->imageUrl; ?>">
                            <?php echo CHtml::image($model->imageUrl, $model->image_alt); ?>
                        </a>
                    </div>

                <?php endif; ?>

                <div class="prev-next">
                    <p>
                        <?php if ($prev): ?>
                    <a class="link prev" rel="nofollow" href="<?php echo $prev->url; ?>#gallery-top">Предыдущее
                        &raquo;</a><?php endif; ?><!--
				--><?php if ($next): ?><a class="link next" rel="nofollow" href="<?php echo $next->url; ?>#gallery-top">
                                &laquo; Следующее</a><?php endif; ?>
                    </p>
                </div>

            </div>

            <div class="info">
                <p class="date"><span><time datetime="<?php echo date('Y-m-d', strtotime($model->date)); ?>" pubdate="pubdate"><?php echo DDateHelper::normdate($model->date); ?></time></span>
                </p>
                <?php if ($model->category): ?>
                    <p class="category">
                        <span><a href="<?php echo $model->category->url; ?>"><?php echo CHtml::encode($model->category->title); ?></a></span>
                    </p>
                <?php endif; ?>
            </div>

            <?php $this->endCache(); ?>
        <?php endif; ?>

        <div class="text">
            <?php echo $this->decodeWidgets($model->text_purified); ?>
        </div>

        <div class="clear"></div>

    </article>

    <aside>

        <?php $this->widget('share.widgets.ShareWidget', array(
            'title' => $model->title,
            'description' => $model->description,
            'image' => $model->imageUrl,
        )); ?>

    </aside>

<?php if (Yii::app()->moduleManager->active('comment')): ?>
    <?php $this->widget('comment.widgets.CommentsWidget', array(
        'material_id' => $model->id,
        'type' => GalleryPhotoComment::TYPE_OF_COMMENT,
        'url' => $model->url,
    )); ?>
<?php endif; ?>