<?php
$this->pageTitle='Редактор фотографии';
$this->breadcrumbs=array(
    $model->user->username => $model->user->url,
    'Фотографии' => $this->createUrl('/userphoto/default/index', array('username'=>$model->user->username)),
    $model->id,
);
if ($this->is(Access::ROLE_CONTROL)){

    if ($this->moduleAllowed('userphoto')) $this->admin[] = array('label'=>'Фотографии', 'url'=>$this->createUrl('/userphoto/photoAdmin/index'));
    if ($this->moduleAllowed('userphoto') && Yii::app()->moduleManager->active('comment') && $this->moduleAllowed('comment')) $this->admin = array_merge($this->admin, Yii::app()->moduleManager->notifications($this->module->id));

    $this->info = 'Фотографии пользователя';
}?>

<h1>Редактирование фотографии</h1>

<article class="entry">
    <?php if ($model->file) : ?>
        <p class="thumb" style="width: 98%">
            <?php echo CHtml::image($model->imageUrl, $model->title, array('style'=>'max-width: 100%')); ?>
        </p>
    <?php endif; ?>

    <div class="clear"></div>
</article>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>

