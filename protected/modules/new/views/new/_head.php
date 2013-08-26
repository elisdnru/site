<?php
$this->pageTitle = $model->title;
$this->description = $model->description;
$this->keywords = $model->keywords;

$this->breadcrumbs=array();
if ($model->page) $this->breadcrumbs = $model->page->getBreadcrumbs(true);
$this->breadcrumbs[]= $model->title;

if ($this->is(Access::ROLE_CONTROL)){

    $this->admin[] = array('label'=>'Редактировать', 'url'=>$this->createUrl('/new/newAdmin/update', array('id'=>$model->id)));
    if ($this->moduleAllowed('newsgallery')) $this->admin[] = array('label'=>'Галереи', 'url'=>$this->createUrl('/newsgallery/galleryAdmin/index'));
    if ($this->moduleAllowed('newsgallery')) if ($model->gallery) $this->admin[] = array('label'=>'Редактировать галерею', 'url'=>$this->createUrl('/newsgallery/galleryAdmin/files', array('id'=>$model->gallery_id)));
    if ($this->moduleAllowed('page')) $this->admin[] = array('label'=>'Редактировать страницу', 'url'=>$this->createUrl('/page/pageAdmin/update', array('id'=>$model->page_id)));
    $this->admin[] = array('label'=>'Новости', 'url'=>$this->createUrl('/new/newAdmin/index'));
    if ($this->moduleAllowed('comment')) if (Yii::app()->moduleManager->active('comment'))
        $this->admin[] = array('label'=>'Комментарии (' . $model->comments_new_count . ' ' . DNumberHelper::Plural($model->comments_new_count, array('новый', 'новых', 'новых')) . ')', 'url'=>$this->createUrl('/new/commentAdmin/index', array('id'=>$model->id)));

    $this->info = 'Нажмите «Редактировать» чтобы изменить статью';
}?>

<?php $this->widget('colorbox.widgets.ColorboxWidget'); ?>

<?php if (!$model->public): ?>
<div class="flash-error">Внимание! Новость скрыта от публикации!</div>
<?php endif; ?>