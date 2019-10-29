<?php
use app\assets\ColorboxAsset;
use app\components\widgets\ShareWidget;
use app\modules\portfolio\models\Work;
use app\modules\user\models\Access;
use yii\caching\TagDependency;
use yii\helpers\Html;

/** @var $model Work */

$this->context->layout = 'index';

$this->title = $model->title;
$this->registerMetaTag(['name' => 'description', 'content' => $model->description]);

$this->params['breadcrumbs'] = [
    'Портфолио' => ['/portfolio/default/index']
];
$this->params['breadcrumbs'] = array_merge($this->params['breadcrumbs'], $model->category->getBreadcrumbs(true));
$this->params['breadcrumbs'][] = $model->title;

if (Yii::$app->user->can(Access::CONTROL)) {
    if (Yii::$app->moduleManager->allowed('portfolio')) {
        $this->params['admin'][] = ['label' => 'Редактировать', 'url' => ['/portfolio/admin/work/update', 'id' => $model->id]];
        $this->params['admin'][] = ['label' => 'Редактировать категорию', 'url' => ['/portfolio/admin/category/update', 'id' => $model->category_id]];
        $this->params['admin'][] = ['label' => 'Работы', 'url' => ['/portfolio/admin/work/index']];
        $this->params['admin'][] = ['label' => 'Добавить работу', 'url' => ['/portfolio/admin/work/create']];
    }
} ?>

<?php ColorboxAsset::register($this) ?>

<?php if (!$model->public) : ?>
    <div class="flash-error">Внимание! Новость скрыта от публикации!</div>
<?php endif; ?>

<article class="entry">

    <?php if ($this->beginCache(__FILE__ . __LINE__ . '_post_' . $model->id, ['dependency' => new TagDependency(['tags' => 'portfolio'])])) : ?>
        <header>

            <h1><?= Html::encode($model->title) ?></h1>

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
                    <a class="lightbox" href="<?= $model->imageUrl ?>"><?= CHtml::image($model->getImageThumbUrl(), $model->title, $properties) ?></a>
                </p>

            <?php endif; ?>

            <div class="info">
                <div class="category">
                    <span><a href="<?= $model->category->url ?>"><?= Html::encode($model->category->title) ?></a></span>
                </div>
            </div>

            <div class="short">
                <?= trim($model->short_purified) ?>
            </div>

        </header>
        <?php $this->endCache(); ?>
    <?php endif; ?>

    <div class="clear"></div>

    <div class="text">
        <?= $this->decodeWidgets(trim($model->text_purified)) ?>
    </div>

    <div class="clear"></div>

</article>

<?= ShareWidget::widget([
    'title' => $model->title,
    'description' => $model->description,
    'image' => $model->imageUrl,
]) ?>
