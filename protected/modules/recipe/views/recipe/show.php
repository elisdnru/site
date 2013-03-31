<?php
/* @var $this DController */
/* @var $page Page */
/* @var $recipe Recipe */

$this->pageTitle = $recipe->title;
$this->description = $recipe->description;
$this->keywords = $recipe->keywords;

$this->breadcrumbs=array(
    $page->title => $this->createUrl('/recipe/default/index'),
    $recipe->title,
);

if ($this->is(Access::ROLE_CONTROL)){

    if ($this->moduleAllowed('recipe')) $this->admin[] = array('label'=>'Редактировать', 'url'=>$this->createUrl('/recipe/recipeAdmin/update', array('id'=>$recipe->id)));
    if ($this->moduleAllowed('gallery')) $this->admin[] = array('label'=>'Галереи', 'url'=>$this->createUrl('/gallery/galleryAdmin/index'));

    $this->info = 'Нажмите «Редактировать» чтобы изменить рецепт';
}?>

<?php $this->widget('colorbox.widgets.ColorboxWidget'); ?>

<article class="entry">

<?php if($this->beginCache(__FILE__.__LINE__.'_recipe_'.$recipe->id, array('duration'=>3600))) { ?>
    <header>
    <h1><?php echo CHtml::encode($recipe->title); ?></h1>

    <?php if ($recipe->image) : ?>

    <p class="thumb"><a class="lightbox" href="<?php echo $recipe->imageUrl; ?>">
        <?php echo CHtml::image($recipe->imageThumbUrl, $recipe->image_alt); ?>
    </a></p>

    <?php endif; ?>

    <div class="info">
        <p class="date"><span><time datetime="<?php echo date('Y-m-d', strtotime($recipe->date)); ?>" pubdate="pubdate"><?php echo DDateHelper::normdate($recipe->date); ?></time></span></p>
    </div>
    </header>
<?php $this->endCache(); } ?>

    <div class="text">
        <?php echo $this->decodeWidgets(trim($recipe->text_purified)); ?>
    </div>

    <div class="clear"></div>

<?php if($this->beginCache(__FILE__.__LINE__.'_newpage_'.$recipe->id, array('duration'=>3600))) { ?>

    <?php $this->widget('gallery.widgets.GalleryWidget', array(
        'id'=>$recipe->gallery_id,
    )); ?>

<?php $this->endCache(); } ?>

</article>

<aside>

<?php $this->widget('share.widgets.ShareWidget', array(
    'title'=>$recipe->title,
    'description'=>$recipe->description,
    'image'=>$recipe->imageUrl,
)); ?>

</aside>