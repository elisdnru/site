<?php
$this->pageTitle = $model->title;
$this->description = $model->description;
$this->keywords = $model->keywords;

$this->breadcrumbs=array(
    'Персонал' => $this->createUrl('/personnel/default/index')
);
$this->breadcrumbs = array_merge($this->breadcrumbs, $model->category->getBreadcrumbs(true));
$this->breadcrumbs[]= $model->title;

if ($this->is(Access::ROLE_CONTROL)){

    if ($this->moduleAllowed('personnel')) $this->admin[] = array('label'=>'Редактировать', 'url'=>$this->createUrl('/personnel/employeeAdmin/update', array('id'=>$model->id)));
    if ($this->moduleAllowed('personnel')) $this->admin[] = array('label'=>'Редактировать категорию', 'url'=>$this->createUrl('/personnel/categoryAdmin/update', array('id'=>$model->category_id)));
    if ($this->moduleAllowed('personnel')) $this->admin[] = array('label'=>'Сотрудники', 'url'=>$this->createUrl('/personnel/employeeAdmin/index'));
    if ($this->moduleAllowed('personnel')) $this->admin[] = array('label'=>'Добавить сотрудника', 'url'=>$this->createUrl('/personnel/employeeAdmin/create'));

    $this->info = '<p>Нажмите «Редактировать» чтобы изменить данные</p>';
}?>

<?php $this->widget('colorbox.widgets.ColorboxWidget'); ?>

<?php if (!$model->public): ?>
<div class="flash-error">Внимание! Сотрудник скрыт от публикации!</div>
<?php endif; ?>

<article class="entry">

<?php if($this->beginCache(__FILE__.__LINE__.'_post_'.$model->id, array('dependency'=>new Tags('personnel')))) { ?>
    <header>

        <h1><?php echo CHtml::encode($model->title); ?></h1>

        <?php if ($model->image && $model->image_show) : ?>
    
            <?php
            $properties = array();
            if ($model->image_width) $properties['width'] = $model->image_width;
            if ($model->image_height) $properties['height'] = $model->image_height;
            ?>
    
            <p class="thumb"><a class="lightbox" href="<?php echo $model->imageUrl; ?>"><?php echo CHtml::image($model->getImageThumbUrl(), $model->title, $properties); ?></a></p>
    
        <?php endif; ?>

        <div class="info">
            <p class="category"><span><a href="<?php echo $model->category->url; ?>"><?php echo CHtml::encode($model->category->title); ?></a></span></p>
        </div>

        <div class="short">
            <?php echo trim($model->short_purified); ?>
        </div>

    </header>
<?php $this->endCache(); } ?>

    <div class="clear"></div>

    <div class="text">
        <?php echo $this->decodeWidgets(trim($model->text_purified)); ?>
    </div>

    <div class="clear"></div>

</article>

<?php $this->widget('application.modules.contact.widgets.ContactWidget'); ?>

<?php if (preg_match('|<pre\sclass=\"brush\s?:\s?\w+\">|', $model->text)): ?>
<?php Yii::app()->syntaxhighlighter->addHighlighter(); ?>
<?php endif; ?>