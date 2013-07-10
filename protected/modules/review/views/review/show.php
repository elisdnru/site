<?php
/* @var $this DController */
/* @var $page Page */
/* @var $review Review */

$this->pageTitle = $review->name . ' сказал ' . DDateHelper::normdate($review->date);
$this->description = '';
$this->keywords = '';

$this->breadcrumbs=array(
    $page->title => $this->createUrl('/review/default/index'),
    'Отзыв: ' . $review->name,
);

if ($this->is(Access::ROLE_CONTROL)){

    if ($this->moduleAllowed('review')) $this->admin[] = array('label'=>'Редактировать', 'url'=>$this->createUrl('/review/reviewAdmin/update', array('id'=>$review->id)));
    if ($this->moduleAllowed('gallery')) $this->admin[] = array('label'=>'Галереи', 'url'=>$this->createUrl('/gallery/galleryAdmin/index'));

    $this->info = 'Нажмите «Редактировать» чтобы изменить рецепт';
}?>

<article class="entry">

<?php if($this->beginCache(__FILE__.__LINE__.'_recipe_'.$review->id, array('dependency'=>new Tags('review')))) { ?>
    <header>
    <h1><?php echo CHtml::encode($review->name); ?></h1>

    <div class="info">
        <p class="date"><span><time datetime="<?php echo date('Y-m-d', strtotime($review->date)); ?>" pubdate="pubdate"><?php echo DDateHelper::normdate($review->date); ?></time></span></p>
    </div>
    </header>
<?php $this->endCache(); } ?>

    <div class="text">
        <?php echo $review->text_purified; ?>
    </div>

    <div class="clear"></div>

</article>

<aside>

<?php $this->widget('share.widgets.ShareWidget', array(
    'title'=>'Отзыв: ' . $review->name,
    'description'=>'',
    'image'=>'',
)); ?>

</aside>