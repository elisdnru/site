<?php use app\extensions\cachetagging\Tags;
use app\modules\portfolio\models\Category;

if ($this->beginCache(__FILE__ . __LINE__, ['dependency' => new Tags('block')])) : ?>
    <?php $this->beginWidget(\app\components\widgets\Portlet::class, ['title' => 'Также я здесь', 'htmlOptions' => ['class' => 'portlet portlet-fixed']]); ?>
    <?php $this->widget(\app\components\widgets\FollowWidget::class); ?>
    <?php $this->endWidget(); ?>
    <?php $this->endCache(); ?>
<?php endif; ?>

<?php if ($this->menu) : ?>
    <?php $this->beginWidget(\app\components\widgets\Portlet::class, ['title' => 'Управление']); ?>
    <?php $this->widget('zii.widgets.CMenu', ['items' => $this->menu]); ?>
    <?php $this->endWidget(); ?>
<?php endif; ?>

<?php $this->beginWidget(\app\components\widgets\Portlet::class, ['title' => 'Разделы портфолио']); ?>
<?php $this->widget('zii.widgets.CMenu', ['items' => Category::model()->cache(0, new Tags('portfolio'))->getMenuList(1000)]); ?>
<?php $this->endWidget(); ?>
