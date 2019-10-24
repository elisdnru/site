<?php use app\components\widgets\FollowWidget;
use app\components\widgets\Portlet;
use app\extensions\cachetagging\Tags;
use app\modules\portfolio\models\Category;
use yii\widgets\Menu;

if ($this->beginCache(__FILE__ . __LINE__, ['dependency' => new Tags('block')])) : ?>
    <?php Yii::app()->controller->beginWidget(Portlet::class, ['title' => 'Также я здесь', 'htmlOptions' => ['class' => 'portlet portlet-fixed']]); ?>
    <?= FollowWidget::widget() ?>
    <?php Yii::app()->controller->endWidget(); ?>
    <?php $this->endCache(); ?>
<?php endif; ?>

<?php Yii::app()->controller->beginWidget(Portlet::class, ['title' => 'Разделы портфолио']); ?>
<?= Menu::widget(['id' => 'portfolio_categories', 'items' => Category::model()->cache(0, new Tags('portfolio'))->getMenuList(1000)]) ?>
<?php Yii::app()->controller->endWidget(); ?>
