<?php
/* @var $this DController */
/* @var $model BlogPost */
/* @var $dataProvider CActiveDataProvider */

$this->pageTitle = $model->pagetitle;
$this->description = $model->description;
$this->keywords = ($model->category ? $model->category->title . ' ' : '') . implode(' ', CHtml::listData($model->tags, 'id', 'title')) . ($model->keywords ? ' ' . $model->keywords : '');

$this->breadcrumbs=array(
    'Блог' => $this->createUrl('/blog')
);

$cs = Yii::app()->clientScript;
$cs->registerMetaTag($model->title, null, null, array('property' => 'og:title'));
$cs->registerMetaTag($model->description, null, null, array('property' => 'og:description'));
$cs->registerMetaTag(Yii::app()->request->getHostInfo() . $model->url, null, null, array('property' => 'og:url'));
if ($model->image) {
    $cs->registerMetaTag(Yii::app()->request->getHostInfo() . $model->imageUrl, null, null, array('property' => 'og:image'));
    $cs->registerLinkTag('image_src', null, Yii::app()->request->getHostInfo() . $model->imageUrl);
}

if ($model->category)
    $this->breadcrumbs = array_merge($this->breadcrumbs, $model->category->getBreadcrumbs(true));

$this->breadcrumbs[]= $model->title;

if ($this->is(Access::ROLE_CONTROL)){

    if ($this->moduleAllowed('blog')) $this->admin[] = array('label'=>'Редактировать', 'url'=>$this->createUrl('/blog/postAdmin/update', array('id'=>$model->id)));
    if ($this->moduleAllowed('blog')) $this->admin[] = array('label'=>'Записи', 'url'=>$this->createUrl('/blog/postAdmin/index'));
    if ($this->moduleAllowed('newsgallery')) $this->admin[] = array('label'=>'Галереи', 'url'=>$this->createUrl('/newsgallery/galleryAdmin/index'));
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
    <header>
		<h1><?php echo CHtml::encode($model->title); ?></h1>

        <!--noindex-->
        <?php if($this->beginCache('banner_post_before', array('dependency'=>new Tags('block')))) { ?>
            <?php $this->widget('application.modules.block.widgets.BlockWidget', array('id'=>'banner_post_before')); ?>
            <?php $this->endCache(); } ?>
        <!--/noindex-->

		<?php if ($model->image && $model->image_show) : ?>
			<?php
			$properties = array();
			if ($model->image_width) $properties['width'] = $model->image_width;
			if ($model->image_height) $properties['height'] = $model->image_height;
			?>
			<p class="thumb"><?php echo CHtml::image($model->imageUrl, $model->image_alt, $properties); ?></p>
		<?php endif; ?>

    </header>

    <div class="text">
        <?php echo $this->decodeWidgets($model->text_purified); ?>
    </div>

    <div class="clear"></div>

<?php if($this->beginCache(__FILE__.__LINE__.'_post_'.$model->id, array('dependency'=>new Tags('newsgallery')))) { ?>

    <?php $this->widget('newsgallery.widgets.NewsGalleryWidget', array(
        'id'=>$model->gallery_id,
    )); ?>

<?php $this->endCache(); } ?>

</article>

<aside>

	<?php if($this->beginCache('banner_post_after', array('dependency'=>new Tags('block')))) { ?>
		<?php $this->widget('application.modules.block.widgets.BlockWidget', array('id'=>'banner_post_after')); ?>
	<?php $this->endCache(); } ?>

    <!--
    <div class="portlet" style="background: #eee; border: 2px dashed #0e76db">
        <div class="portlet-content">
            <div class="subscribe-form">
                <p style="margin: 0">Не забудьте подписаться, чтобы быть в курсе новостей и получать интересные штуки</p>
                <form method="post" action="http://products.elisdn.ru/subscribe/process/?rid[0]=blog" target="_blank" onsubmit="return jc_chkscrfrm(this, false, false, false, false)">
                    <div class="row" style="display: inline-block; padding-right: 20px">
                        <input type="text" name="lead_name" placeholder="Ваше имя" style="width: 170px; padding: 9px; border-color: #aaa">
                    </div>
                    <div class="row" style="display: inline-block; padding-right: 20px">
                        <input type="email" name="lead_email" placeholder="Ваш Email" style="width: 170px; padding: 9px; border-color: #aaa">
                    </div>
                    <div class="row button" style="display: inline-block">
                        <input type="submit" name="" value="Подписаться">
                    </div>
                    <script>jc_setfrmfld()</script>
                </form>
            </div>
        </div>
    </div> -->

    <!--noindex-->
    <?php
    $links = array();
    foreach ($model->tags as $tag){
        $links[] = '<span data-href="' . CHtml::encode($tag->url) . '">' . CHtml::encode($tag->title) . '</span>';
    }
    ?>
	<p class="entry_date">Дата: <span class="enc-date" data-date="<?php echo DDateHelper::normdate($model->date); ?>">&nbsp;</span></p>
    <p class="entry_tags">Метки: <?php echo implode('', $links); ?></p>
    <div class="clear"></div>
    <!--/noindex-->

    <div class="donate-btn" style=""><a href="/donate">Поддержать проект</a></div>

    <?php $this->widget('share.widgets.ShareWidget', array(
        'title'=>$model->title,
        'description'=>$model->description,
        'image'=>$model->imageUrl,
    )); ?>

    <div class="clear"></div>

    <?php if($this->beginCache(__FILE__.__LINE__.'_post_other_'.$model->id, array('dependency'=>new Tags('blog')))) { ?>

        <?php $this->widget('blog.widgets.ThemePostsWidget', array(
            'current'=>$model->id,
            'group'=>$model->group_id,
        )); ?>

    <?php $this->endCache(); } ?>

    <?php if($this->beginCache(__FILE__.__LINE__.'_post_other_'.$model->id, array('dependency'=>new Tags('blog')))) { ?>
    <?php $this->widget('blog.widgets.OtherPostsWidget', array(
        //'category'=>$model->category_id,
        'skip'=>$model->id,
        'limit'=>2,
    )); ?>
    <?php $this->endCache(); } ?>

</aside>

<?php if (Yii::app()->moduleManager->active('comment')): ?>
<?php $this->widget('comment.widgets.CommentsWidget', array(
    'material_id'=>$model->id,
    'authorId'=>$model->author_id,
    'type'=>BlogPostComment::TYPE_OF_COMMENT,
    'url'=>$model->url,
)); ?>
<?php endif; ?>
