<?php use app\components\widgets\FollowWidget;
use app\components\widgets\Portlet;
use app\extensions\cachetagging\Tags;
use app\modules\portfolio\models\Category;

if ($this->beginCache(__FILE__ . __LINE__, ['dependency' => new Tags('block')])) : ?>
    <?php $this->beginWidget(Portlet::class, ['title' => 'Также я здесь', 'htmlOptions' => ['class' => 'portlet portlet-fixed']]); ?>
    <?= FollowWidget::widget() ?>
    <?php $this->endWidget(); ?>
    <?php $this->endCache(); ?>
<?php endif; ?>

<?php $this->beginWidget(Portlet::class, ['title' => 'Разделы портфолио']); ?>
<?php $this->widget('zii.widgets.CMenu', ['id' => 'portfolio_categories', 'items' => Category::model()->cache(0, new Tags('portfolio'))->getMenuList(1000)]); ?>
<?php $this->endWidget(); ?>
