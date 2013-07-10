<?php
/* @var $this DController */
/* @var $model UserPhoto */

$this->pageTitle = $model->title;
$this->description = '';
$this->keywords = '';

$this->breadcrumbs=array(
    $model->user->username => $model->user->url,
    'Фотографии' => $this->createUrl('/userphoto/default/index', array('username'=>$model->user->username)),
    $model->title,
);

if ($this->is(Access::ROLE_CONTROL)){

    if ($this->moduleAllowed('userphoto')) $this->admin[] = array('label'=>'Фотографии', 'url'=>$this->createUrl('/userphoto/photoAdmin/index'));
    if ($this->moduleAllowed('userphoto')) $this->admin[] = array('label'=>'Редактировать', 'url'=>$this->createUrl('/userphoto/photoAdmin/update', array('id'=>$model->id)));
    if ($this->moduleAllowed('userphoto') && Yii::app()->moduleManager->active('comment') && $this->moduleAllowed('comment')) $this->admin = array_merge($this->admin, Yii::app()->moduleManager->notifications($this->module->id));

    $this->info = 'Нажмите «Редактировать» чтобы изменить описание';
}?>

<?php $this->widget('colorbox.widgets.ColorboxWidget'); ?>

<article class="entry">

    <?php if ($model->user_id === Yii::app()->user->id): ?>
        <p>
            <a href="<?php echo $this->createUrl('update', array('id'=>$model->id)); ?>">Редактировать</a>
        </p>
    <?php endif; ?>

    <header>
        <h1><?php echo CHtml::encode($model->title ? $model->title : 'Без названия'); ?></h1>

        <?php if ($model->file) : ?>

            <p class="thumb" style="width: 98%"><a class="lightbox" href="<?php echo $model->imageUrl; ?>">
                <?php echo CHtml::image($model->imageUrl, $model->title, array('style'=>'max-width: 100%')); ?>
            </a></p>

        <?php endif; ?>
    </header>

    <div class="text">
        <?php echo $this->decodeWidgets(trim($model->text_purified)); ?>
    </div>

    <div class="clear"></div>

</article>

<aside>

    <?php if($this->beginCache(__FILE__.__LINE__.'_newpage_'.$model->id, array('dependency'=>new Tags('userphoto')))) { ?>
        <?php $this->widget('share.widgets.ShareWidget', array(
            'title'=>$model->title,
            'description'=>$model->title,
            'image'=>$model->imageUrl,
        )); ?>
    <?php $this->endCache(); } ?>

    <hr />

</aside>

<?php if (Yii::app()->moduleManager->active('comment')): ?>
    <?php $this->widget('comment.widgets.CommentsWidget', array(
        'material_id'=>$model->id,
        'authorId'=>$model->user_id,
        'type'=>UserPhotoComment::TYPE_OF_COMMENT,
        'url'=>$model->url,
    )); ?>
<?php endif; ?>