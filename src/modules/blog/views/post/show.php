<?php
use app\assets\HighlightAsset;
use app\components\helpers\StyleHelper;
use app\components\widgets\ShareWidget;
use app\modules\block\widgets\BlockWidget;
use app\modules\blog\models\Post;
use app\modules\blog\models\Comment;
use app\components\helpers\DateHelper;
use app\components\helpers\NumberHelper;
use app\modules\blog\widgets\OtherPostsWidget;
use app\modules\blog\widgets\ThemePostsWidget;
use app\modules\comment\widgets\CommentsWidget;
use app\modules\user\models\Access;
use yii\caching\TagDependency;

/** @var $this \yii\web\View|\app\components\behaviors\InlineWidgetsBehavior */
/** @var $model Post */
/** @var $dataProvider CActiveDataProvider */

$this->context->layout = 'post';

$this->title = $model->pagetitle;

$this->registerMetaTag(['name' => 'description', 'content' => $model->description]);

$this->params['breadcrumbs'] = [
    'Блог' => ['/blog']
];

$host = Yii::app()->request->getHostInfo();

$this->registerMetaTag(['property' => 'og:title', 'content' => $model->title]);
$this->registerMetaTag(['property' => 'og:description', 'content' => $model->description]);
$this->registerMetaTag(['property' => 'og:url', 'content' => $host . $model->url]);

if ($model->image) {
    $this->registerMetaTag(['property' => 'og:image', 'content' => $host . $model->imageUrl]);
    $this->registerLinkTag(['rel' => 'image_src', 'href' => $host . $model->imageUrl]);
}

if ($model->styles) {
    $this->registerCss(StyleHelper::minimize(strip_tags($model->styles)));
}

if ($model->category) {
    $this->params['breadcrumbs'] = array_merge($this->params['breadcrumbs'], $model->category->getBreadcrumbs(true));
}

$this->params['breadcrumbs'][] = $model->title;

if (Yii::app()->user->checkAccess(Access::CONTROL)) {
    if (Yii::$app->moduleManager->allowed('blog')) {
        $this->params['admin'][] = ['label' => 'Редактировать', 'url' => ['/blog/admin/post/update', 'id' => $model->id]];
        $this->params['admin'][] = ['label' => 'Записи', 'url' => ['/blog/admin/post/index']];
        if ($model->category) {
            $this->params['admin'][] = ['label' => 'Редактировать категорию', 'url' => ['admin/category/update', 'id' => $model->category_id]];
        }
    }
    if (Yii::$app->moduleManager->allowed('comment')) {
        $count = $model->getCommentsNewCount();
        $this->params['admin'][] = ['label' => 'Комментарии (' . $count . ' ' . NumberHelper::Plural($count, ['новый', 'новых', 'новых']) . ')', 'url' => ['/blog/admin/comment/index', 'id' => $model->id]];
    }
}

HighlightAsset::register($this);
?>

<?php if (!$model->public) : ?>
    <div class="flash-error">Внимание! Новость скрыта от публикации!</div>
<?php endif; ?>

<article class="entry">
    <header>
        <h1><?= CHtml::encode($model->title) ?></h1>

        <!--noindex-->
        <?php if ($this->beginCache('banner_post_before', ['dependency' => new TagDependency(['tags' => 'block'])])) : ?>
            <?= BlockWidget::widget(['id' => 'banner_post_before']) ?>
            <?php $this->endCache(); ?>
        <?php endif; ?>
        <!--/noindex-->

        <?php if ($model->image && $model->image_show) : ?>
            <?php
            $properties = array_filter([
                'width' => $model->image_width,
                'height' => $model->image_height,
            ]);
            ?>
            <p class="thumb"><?= CHtml::image($model->imageUrl, $model->image_alt, $properties) ?></p>
        <?php endif; ?>

    </header>

    <div class="text">
        <?= $this->decodeWidgets($model->text_purified) ?>
    </div>

    <div class="clear"></div>

</article>

<aside>

    <?php if ($this->beginCache('banner_post_after', ['dependency' => new TagDependency(['tags' => 'block'])])) : ?>
        <?= BlockWidget::widget(['id' => 'banner_post_after']) ?>
        <?php $this->endCache(); ?>
    <?php endif; ?>

    <div class="subscribe-after-post">
        <p class="title">Не пропускайте новые статьи, бонусы и мастер-классы:</p>
        <div class="subscribe-form">
            <form method="post" action="//elisdn.justclick.ru/subscribe/process/?rid%5B0%5D=blog&tag=bottom" target="_blank">
                <div class="row">
                    <input type="text" name="lead_name" placeholder="Ваше имя" required />
                </div>
                <div class="row">
                    <input type="email" name="lead_email" placeholder="Ваш Email" required />
                </div>
                <div class="row button">
                    <button type="submit">Подписаться</button>
                </div>
            </form>
        </div>
    </div>

    <!--noindex-->
    <?php
    $links = [];
    foreach ($model->tags as $tag) {
        $links[] = '<a href="' . CHtml::encode($tag->url) . '">' . CHtml::encode($tag->title) . '</a>';
    }
    ?>
    <p class="entry_date">
        Дата: <span class="enc-date" data-date="<?= DateHelper::normdate($model->date) ?>">&nbsp;</span>
    </p>
    <p class="entry_tags">Метки: <?= implode('', $links) ?></p>
    <div class="clear"></div>
    <!--/noindex-->

    <div class="block-title">Поделиться</div>

    <div class="donate-btn"><a href="/donate">Поддержать проект</a></div>

    <?= ShareWidget::widget([
        'title' => $model->title,
        'description' => $model->description,
        'image' => $model->imageUrl,
    ]) ?>

    <div class="clear"></div>

    <?php if ($this->beginCache(__FILE__ . __LINE__ . '_post_other_' . $model->id, ['dependency' => new TagDependency(['tags' => 'blog'])])) : ?>
        <?= ThemePostsWidget::widget([
            'current' => $model->id,
            'group' => $model->group_id,
        ]) ?>
        <?php $this->endCache(); ?>
    <?php endif; ?>

    <?php if ($this->beginCache(__FILE__ . __LINE__ . '_post_other_' . $model->id, ['dependency' => new TagDependency(['tags' => 'blog'])])) : ?>
        <?= OtherPostsWidget::widget([
            //'category'=>$model->category_id,
            'skip' => $model->id,
            'limit' => 2,
        ]) ?>
        <?php $this->endCache(); ?>
    <?php endif; ?>

</aside>

<?= CommentsWidget::widget([
    'material_id' => $model->id,
    'authorId' => $model->author_id,
    'type' => Comment::TYPE_OF_COMMENT,
    'url' => $model->url,
]) ?>
