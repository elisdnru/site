<?php declare(strict_types=1);

use app\assets\HighlightAsset;
use app\components\CSSMinimizer;
use app\components\DateFormatter;
use app\components\InlineWidgetsBehavior;
use app\components\Pluraliser;
use app\modules\block\widgets\BlockWidget;
use app\modules\blog\models\Comment;
use app\modules\blog\models\Post;
use app\modules\blog\widgets\OtherPostsWidget;
use app\modules\blog\widgets\ThemePostsWidget;
use app\modules\comment\widgets\CommentsWidget;
use app\modules\user\models\Access;
use app\widgets\Share;
use app\widgets\SubscribeAfterPost;
use yii\caching\TagDependency;
use yii\helpers\Html;
use yii\web\View;

/**
 * @var InlineWidgetsBehavior|View $this
 * @psalm-var View&InlineWidgetsBehavior $this
 * @var Post $model
 */
$this->context->layout = 'post';

$this->title = $model->meta_title;

$this->registerMetaTag(['name' => 'description', 'content' => $model->meta_description]);

$this->params['breadcrumbs'] = [
    'Блог' => ['/blog'],
];

$host = Yii::$app->request->getHostInfo() ?: '';

$this->registerMetaTag(['property' => 'og:title', 'content' => $model->title]);
$this->registerMetaTag(['property' => 'og:meta_description', 'content' => $model->meta_description]);
$this->registerMetaTag(['property' => 'og:url', 'content' => $host . $model->getUrl()]);

if ($model->image) {
    $this->registerMetaTag(['property' => 'og:image', 'content' => $host . $model->getImageUrl()]);
    $this->registerLinkTag(['rel' => 'image_src', 'href' => $host . $model->getImageUrl()]);
}

if ($model->styles) {
    $this->registerCss(CSSMinimizer::minimize(strip_tags($model->styles)));
}

$this->params['breadcrumbs'] = array_merge($this->params['breadcrumbs'], $model->category->getBreadcrumbs(true));

$this->params['breadcrumbs'][] = $model->title;

if (Yii::$app->user->can(Access::CONTROL)) {
    if (Yii::$app->moduleAdminAccess->isGranted('blog')) {
        $this->params['admin'][] = ['label' => 'Редактировать', 'url' => ['/blog/admin/post/update', 'id' => $model->id]];
        $this->params['admin'][] = ['label' => 'Записи', 'url' => ['/blog/admin/post/index']];
        $this->params['admin'][] = ['label' => 'Редактировать категорию', 'url' => ['admin/category/update', 'id' => $model->category_id]];
    }
    if (Yii::$app->moduleAdminAccess->isGranted('comment')) {
        $count = $model->getCommentsNewCount();
        $this->params['admin'][] = ['label' => 'Комментарии (' . $count . ' ' . Pluraliser::plural($count, ['новый', 'новых', 'новых']) . ')', 'url' => ['/blog/admin/comment/index', 'id' => $model->id]];
    }
}

HighlightAsset::register($this);
?>

<?php if (!$model->public) : ?>
    <div class="flash-error">Внимание! Новость скрыта от публикации!</div>
<?php endif; ?>

<article class="entry">
    <header>
        <h1><?= Html::encode($model->title); ?></h1>

        <!--noindex-->
        <?php if ($this->beginCache('banner_post_before', ['dependency' => new TagDependency(['tags' => 'block'])])) : ?>
            <?= BlockWidget::widget(['id' => 'banner_post_before']); ?>
            <?php $this->endCache(); ?>
        <?php endif; ?>
        <!--/noindex-->

        <?php if ($model->image && $model->image_show) : ?>
            <?php
            $properties = array_filter([
                'alt' => $model->image_alt,
                'width' => $model->image_width,
                'height' => $model->image_height,
            ]);
            ?>
            <p class="thumb"><?= Html::img($model->getImageUrl(), $properties); ?></p>
        <?php endif; ?>

    </header>

    <div class="text">
        <?= $this->decodeWidgets($model->text_purified); ?>
    </div>

    <div class="clear"></div>

</article>

<aside>

    <?php if ($this->beginCache('banner_post_after', ['dependency' => new TagDependency(['tags' => 'block'])])) : ?>
        <?= BlockWidget::widget(['id' => 'banner_post_after']); ?>
        <?php $this->endCache(); ?>
    <?php endif; ?>

    <?= SubscribeAfterPost::widget(); ?>

    <!--noindex-->
    <?php
    $links = [];
    foreach ($model->tags as $tag) {
        $links[] = '<a href="' . Html::encode($tag->getUrl()) . '">' . Html::encode($tag->title) . '</a>';
    }
    ?>
    <p class="entry-date">
        Дата: <span class="enc-date" data-date="<?= DateFormatter::format($model->date); ?>">&nbsp;</span>
    </p>
    <p class="entry-tags">Метки: <?= implode('', $links); ?></p>
    <div class="clear"></div>
    <!--/noindex-->

    <div class="block-title">Поделиться</div>

    <div class="donate-btn"><a href="/donate">Поддержать проект</a></div>

    <?= Share::widget([
        'title' => $model->title,
        'description' => $model->meta_description,
        'image' => $model->getImageUrl(),
    ]); ?>

    <div class="clear"></div>

    <?php if ($this->beginCache(__FILE__ . __LINE__ . '_post_other_' . $model->id, ['dependency' => new TagDependency(['tags' => 'blog'])])) : ?>
        <?= ThemePostsWidget::widget([
            'current' => $model->id,
            'group' => $model->group_id,
        ]); ?>
        <?php $this->endCache(); ?>
    <?php endif; ?>

    <?php if ($this->beginCache(__FILE__ . __LINE__ . '_post_other_' . $model->id, ['dependency' => new TagDependency(['tags' => 'blog'])])) : ?>
        <?= OtherPostsWidget::widget([
            //'category'=>$model->category_id,
            'skip' => $model->id,
            'limit' => 2,
        ]); ?>
        <?php $this->endCache(); ?>
    <?php endif; ?>

</aside>

<?= CommentsWidget::widget([
    'material_id' => $model->id,
    'authorId' => $model->author_id,
    'type' => Comment::TYPE_OF_COMMENT,
    'url' => $model->getUrl(),
]); ?>
