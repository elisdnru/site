<?php

use app\extensions\cachetagging\Tags;
use app\modules\user\models\Access;

/** @var $model \app\modules\portfolio\models\Work */

$this->layout = '/layouts/index';

$this->title = $model->title;
$this->description = $model->description;
$this->keywords = $model->keywords;

$this->params['breadcrumbs'] = [
    'Портфолио' => $this->createUrl('/portfolio/default/index')
];
$this->params['breadcrumbs'] = array_merge($this->params['breadcrumbs'], $model->category->getBreadcrumbs(true));
$this->params['breadcrumbs'][] = $model->title;

if (Yii::app()->user->checkAccess(Access::ROLE_CONTROL)) {
    if (Yii::app()->moduleManager->allowed('portfolio')) {
        $this->admin[] = ['label' => 'Редактировать', 'url' => $this->createUrl('/portfolio/admin/work/update', ['id' => $model->id])];
        $this->admin[] = ['label' => 'Редактировать категорию', 'url' => $this->createUrl('/portfolio/admin/category/update', ['id' => $model->category_id])];
        $this->admin[] = ['label' => 'Работы', 'url' => $this->createUrl('/portfolio/admin/work/index')];
        $this->admin[] = ['label' => 'Добавить работу', 'url' => $this->createUrl('/portfolio/admin/work/create')];
    }
} ?>

<?php $this->widget(\app\components\widgets\ColorboxWidget::class); ?>

<?php if (!$model->public) : ?>
    <div class="flash-error">Внимание! Новость скрыта от публикации!</div>
<?php endif; ?>

<article class="entry">

    <?php if ($this->beginCache(__FILE__ . __LINE__ . '_post_' . $model->id, ['dependency' => new Tags('portfolio')])) : ?>
        <header>

            <h1><?php echo CHtml::encode($model->title); ?></h1>

            <?php if ($model->image && $model->image_show) : ?>
                <?php
                $properties = [];
                if ($model->image_width) {
                    $properties['width'] = $model->image_width;
                }
                if ($model->image_height) {
                    $properties['height'] = $model->image_height;
                }
                ?>

                <p class="thumb">
                    <a class="lightbox" href="<?php echo $model->imageUrl; ?>"><?php echo CHtml::image($model->getImageThumbUrl(), $model->title, $properties); ?></a>
                </p>

            <?php endif; ?>

            <div class="info">
                <p class="category">
                    <span><a href="<?php echo $model->category->url; ?>"><?php echo CHtml::encode($model->category->title); ?></a></span>
                </p>
            </div>

            <div class="short">
                <?php echo trim($model->short_purified); ?>
            </div>

        </header>
        <?php $this->endCache(); ?>
    <?php endif; ?>

    <div class="clear"></div>

    <div class="text">
        <?php echo $this->decodeWidgets(trim($model->text_purified)); ?>
    </div>

    <div class="clear"></div>

</article>

<?php $this->widget(\app\components\widgets\ShareWidget::class, [
    'title' => $model->title,
    'description' => $model->description,
    'image' => $model->imageUrl,
]); ?>

<?php if (preg_match('|<pre\sclass=\"brush\s?:\s?\w+\">|', $model->text)) : ?>
    <?php Yii::app()->syntaxhighlighter->addHighlighter(); ?>
<?php endif; ?>
