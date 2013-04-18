<?php
/* @var $this DController */
/* @var $model BlogPost */
/* @var $dataProvider CActiveDataProvider */

$this->pageTitle = $model->pagetitle;
$this->description = $model->description;
$this->keywords = $model->keywords;

$this->breadcrumbs=array(
    'Блог' => $this->createUrl('/blog')
);

if ($model->category)
    $this->breadcrumbs = array_merge($this->breadcrumbs, $model->category->getBreadcrumbs(true));

$this->breadcrumbs[]= $model->title;

if ($this->is(Access::ROLE_CONTROL)){

    if ($this->moduleAllowed('blog')) $this->admin[] = array('label'=>'Редактировать', 'url'=>$this->createUrl('/blog/postAdmin/update', array('id'=>$model->id)));
    if ($this->moduleAllowed('blog')) $this->admin[] = array('label'=>'Записи', 'url'=>$this->createUrl('/blog/postAdmin/index'));
    if ($this->moduleAllowed('gallery')) $this->admin[] = array('label'=>'Галереи', 'url'=>$this->createUrl('/gallery/galleryAdmin'));
    if ($this->moduleAllowed('blog') && $model->category) $this->admin[] = array('label'=>'Редактировать категорию', 'url'=>$this->createUrl('categoryAdmin/update', array('id'=>$model->category_id)));
    if ($this->moduleAllowed('comment') && Yii::app()->moduleManager->active('comment'))
        $this->admin[] = array('label'=>'Комментарии (' . $model->comments_new_count.' ' . DNumberHelper::Plural($model->comments_new_count, array('новый', 'новых', 'новых')) . ')', 'url'=>$this->createUrl('/blog/commentAdmin/index', array('id'=>$model->id)));

    $this->info = 'Нажмите «Редактировать» чтобы изменить статью';
}

CTextHighlighter::registerCssFile();

?>

<?php $this->widget('colorbox.widgets.ColorboxWidget'); ?>

<?php if (!$model->public): ?>
<div class="flash-error">Внимание! Новость скрыта от публикации!</div>
<?php endif; ?>

<article class="entry">

<?php if($this->beginCache(__FILE__.__LINE__.'_post_'.$model->id, array('duration'=>3600))) { ?>
    <header>
    <h1><?php echo CHtml::encode($model->title); ?></h1>

    <?php if ($model->image && $model->image_show) : ?>

    <p class="thumb"><a class="lightbox" href="<?php echo $model->imageUrl; ?>">
        <?php echo CHtml::image($model->imageThumbUrl, $model->image_alt); ?>
    </a></p>

    <?php endif; ?>

    <div class="info">
        <p class="date"><span><time datetime="<?php echo date('Y-m-d', strtotime($model->date)); ?>" pubdate="pubdate"><?php echo DDateHelper::normdate($model->date); ?></time></span></p>
        <?php if ($model->category): ?>
            <p class="category"><span><a href="<?php echo $model->category->url; ?>"><?php echo CHtml::encode($model->category->title); ?></a></span></p>
        <?php endif; ?>
        <p class="author"><span>Автор: <a href="https://plus.google.com/116153200022401064957?rel=author"><?php echo $model->author->name; ?> <?php echo $model->author->lastname; ?></a></span></p>
    </div>

    </header>
<?php $this->endCache(); } ?>

    <div class="text">
        <?php echo $this->decodeWidgets($model->text_purified); ?>
    </div>

    <div class="clear"></div>

<?php if($this->beginCache(__FILE__.__LINE__.'_post_'.$model->id, array('duration'=>3600))) { ?>

    <?php $this->widget('gallery.widgets.GalleryWidget', array(
        'id'=>$model->gallery_id,
    )); ?>

<?php $this->endCache(); } ?>

</article>

<aside>

    <?php
    $links = array();
    foreach ($model->tags as $tag){
        $links[] = CHtml::link(CHtml::encode($tag->title), $tag->url);
    }
    ?>
    <p class="entry_tags">Метки: <?php echo implode('', $links); ?></p>
    <div class="clear"></div>

    <!-- Новости по теме -->
    <?php if($this->beginCache(__FILE__.__LINE__.'_post_other_'.$model->id, array('duration'=>300))) { ?>

        <?php $this->widget('blog.widgets.ThemePostsWidget', array(
            'current'=>$model->id,
            'group'=>$model->group_id,
        )); ?>

    <?php $this->endCache(); } ?>
    <!-- /Новости по теме -->

    <?php $this->widget('share.widgets.ShareWidget', array(
        'title'=>$model->title,
        'description'=>$model->description,
        'image'=>$model->imageUrl,
    )); ?>

    <?php if($this->beginCache('banner_post', array('duration'=>3600*24))) { ?>
        <?php $this->beginWidget('DPortlet', array('htmlOptions'=>array('class'=>'portlet banner')));?>
        <?php $this->widget('application.modules.block.widgets.BlockWidget', array('id'=>'banner_post')); ?>
        <?php $this->endWidget(); ?>
    <?php $this->endCache(); } ?>

    <!-- Другие новости -->
    <?php if($this->beginCache(__FILE__.__LINE__.'_post_other_'.$model->id, array('duration'=>300))) { ?>
    <?php $this->widget('blog.widgets.OtherPostsWidget', array(
        'category'=>$model->category_id,
        'skip'=>$model->id,
        'limit'=>2,
    )); ?>
    <?php $this->endCache(); } ?>
    <!-- /Другие новости -->

</aside>

<?php if (Yii::app()->moduleManager->active('comment')): ?>
<?php $this->widget('comment.widgets.CommentsWidget', array(
    'material_id'=>$model->id,
    'authorId'=>$model->author_id,
    'type'=>BlogPostComment::TYPE_OF_COMMENT,
    'url'=>$model->url,
)); ?>
<?php endif; ?>