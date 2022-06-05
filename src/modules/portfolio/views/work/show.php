<?php declare(strict_types=1);

use app\assets\PortfolioAsset;
use app\components\shortcodes\Shortcodes;
use app\modules\portfolio\models\Work;
use app\modules\user\models\Access;
use app\widgets\Share;
use yii\caching\TagDependency;
use yii\helpers\Html;
use yii\web\View;

/**
 * @var View $this
 * @var Work $model
 */
$this->context->layout = 'index';

$this->title = $model->meta_title;
$this->registerMetaTag(['name' => 'description', 'content' => $model->meta_description]);

$this->params['breadcrumbs'] = [
    'Портфолио' => ['/portfolio/default/index'],
];
$this->params['breadcrumbs'] = array_merge($this->params['breadcrumbs'], $model->category->getBreadcrumbs(true));
$this->params['breadcrumbs'][] = $model->title;

if (Yii::$app->user->can(Access::CONTROL)) {
    if (Yii::$app->moduleAdminAccess->isGranted('portfolio')) {
        $this->params['admin'][] = ['label' => 'Редактировать', 'url' => ['/portfolio/admin/work/update', 'id' => $model->id]];
        $this->params['admin'][] = ['label' => 'Редактировать категорию', 'url' => ['/portfolio/admin/category/update', 'id' => $model->category_id]];
        $this->params['admin'][] = ['label' => 'Работы', 'url' => ['/portfolio/admin/work/index']];
        $this->params['admin'][] = ['label' => 'Добавить работу', 'url' => ['/portfolio/admin/work/create']];
    }
}

PortfolioAsset::register($this);
?>

<?php if (!$model->public) : ?>
    <div class="flash-error">Внимание! Новость скрыта от публикации!</div>
<?php endif; ?>

<article class="entry">

    <?php if ($this->beginCache(__FILE__ . __LINE__ . '_post_' . $model->id, ['dependency' => new TagDependency(['tags' => 'portfolio'])])) : ?>
        <header>

            <h1><?= Html::encode($model->title); ?></h1>

            <?php if ($model->image && $model->image_show) : ?>
                <?php
                $properties = [
                    'alt' => $model->title,
                    'width' => 250,
                ];
                ?>

                <p class="thumb">
                    <a href="<?= $model->getImageUrl(); ?>"><?= Html::img($model->getImageThumbUrl(250, 0), $properties); ?></a>
                </p>

            <?php endif; ?>

            <div class="info">
                <div class="category">
                    <span><a href="<?= $model->category->getUrl(); ?>"><?= Html::encode($model->category->title); ?></a></span>
                </div>
            </div>

            <div class="short">
                <?= trim($model->short_purified); ?>
            </div>

        </header>
        <?php $this->endCache(); ?>
    <?php endif; ?>

    <div class="clear"></div>

    <div class="text">
        <?php Shortcodes::begin(); ?>
        <?= $model->text_purified; ?>
        <?php Shortcodes::end(); ?>
    </div>

    <div class="clear"></div>

</article>

<?= Share::widget([
    'title' => $model->title,
    'description' => $model->meta_description,
    'image' => $model->getImageUrl(),
]); ?>
