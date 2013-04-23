<?php
/* @var $this DController */
/* @var $page Page */
/* @var $model RubricatorArticle */

$this->pageTitle = $model->title;
$this->description = $model->description;
$this->keywords = $model->keywords;

$this->breadcrumbs = array(
    $page->title => $this->createUrl('/rubricator/default/index'),
);

if ($model->category)
    $this->breadcrumbs[$model->category->title] = $model->category->url;

$this->breadcrumbs[] = $model->title;

if ($this->is(Access::ROLE_CONTROL)){

    if ($this->moduleAllowed('rubricator')) $this->admin[] = array('label'=>'Редактировать', 'url'=>$this->createUrl('/rubricator/articleAdmin/update', array('id'=>$model->id)));
    if ($this->moduleAllowed('gallery')) $this->admin[] = array('label'=>'Галереи', 'url'=>$this->createUrl('/gallery/galleryAdmin/index'));

    $this->info = 'Нажмите «Редактировать» чтобы изменить статью';
}?>

<?php $this->widget('colorbox.widgets.ColorboxWidget'); ?>

<article class="entry">

<?php if($this->beginCache(__FILE__.__LINE__.'_rubricator_'.$model->id, array('duration'=>3600))) { ?>
    <header>
    <h1><?php echo CHtml::encode($model->title); ?></h1>

    <?php if ($model->image) : ?>

    <p class="thumb"><a class="lightbox" href="<?php echo $model->imageUrl; ?>">
        <?php echo CHtml::image($model->imageThumbUrl, $model->image_alt); ?>
    </a></p>

    <?php endif; ?>
    </header>
<?php $this->endCache(); } ?>

    <div class="text">
        <?php echo $this->decodeWidgets(trim($model->text_purified)); ?>
    </div>

    <div class="clear"></div>

<?php if($this->beginCache(__FILE__.__LINE__.'_newpage_'.$model->id, array('duration'=>3600))) { ?>

    <?php $this->widget('gallery.widgets.GalleryWidget', array(
        'id'=>$model->gallery_id,
    )); ?>

<?php $this->endCache(); } ?>

</article>

<aside>

<?php if($this->beginCache(__FILE__.__LINE__.'_newpage_'.$model->id, array('duration'=>3600))) { ?>
<?php $this->widget('share.widgets.ShareWidget', array(
    'title'=>$model->title,
    'description'=>$model->description,
    'image'=>$model->imageUrl,
)); ?>
<?php $this->endCache(); } ?>

<hr />

<h2>Материалы раздела &laquo;<?php echo CHtml::encode($model->title); ?>&raquo;</h2>

<div class="subpages">
	<ul>
		<?php if ($model->articles_newspage && $model->articles_newspage->page): ?><li><?php echo CHtml::link('Статьи', $model->articles_newspage->page->url); ?></li><?php endif; ?>
		<?php if ($model->photos_newspage && $model->photos_newspage->page): ?><li><?php echo CHtml::link('Фотогалерея', $model->photos_newspage->page->url); ?></li><?php endif; ?>
		<?php if ($model->videos_newspage && $model->videos_newspage->page): ?><li><?php echo CHtml::link('Видео', $model->videos_newspage->page->url); ?></li><?php endif; ?>
	</ul>
	<div class="clear"></div>
</div>