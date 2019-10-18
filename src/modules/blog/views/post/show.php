<?php
/** @var $this Controller */

use app\assets\BlogPostAsset;
use app\components\helpers\StyleHelper;
use app\extensions\cachetagging\Tags;
use app\modules\blog\models\Post;
use app\modules\blog\models\Comment;
use app\components\Controller;
use app\components\helpers\DateHelper;
use app\components\helpers\NumberHelper;
use app\modules\user\models\Access;

$this->layout = '/layouts/post';

/** @var $model Post */
/** @var $dataProvider CActiveDataProvider */

$this->pageTitle = $model->pagetitle;
$this->description = $model->description;
$this->keywords = ($model->category ? $model->category->title . ' ' : '') . implode(' ', CHtml::listData($model->tags, 'id', 'title')) . ($model->keywords ? ' ' . $model->keywords : '');

$this->breadcrumbs = [
    'Блог' => $this->createUrl('/blog')
];

$host = Yii::app()->request->getHostInfo();

Yii::$app->view->registerMetaTag(['property' => 'og:title', 'content' => $model->title]);
Yii::$app->view->registerMetaTag(['property' => 'og:description', 'content' => $model->description]);
Yii::$app->view->registerMetaTag(['property' => 'og:url', 'content' => $host . $model->url]);

if ($model->image) {
    Yii::$app->view->registerMetaTag(['property' => 'og:image', 'content' => $host . $model->imageUrl]);
    Yii::$app->view->registerLinkTag(['rel' => 'image_src', 'href' => $host . $model->imageUrl]);
}

if ($model->styles) {
    Yii::app()->clientScript->registerCss('post', StyleHelper::minimize(strip_tags($model->styles)));
}

if ($model->category) {
    $this->breadcrumbs = array_merge($this->breadcrumbs, $model->category->getBreadcrumbs(true));
}

$this->breadcrumbs[] = $model->title;

if (Yii::app()->user->checkAccess(Access::ROLE_CONTROL)) {
    if (Yii::app()->moduleManager->allowed('blog')) {
        $this->admin[] = ['label' => 'Редактировать', 'url' => $this->createUrl('/blog/admin/post/update', ['id' => $model->id])];
        $this->admin[] = ['label' => 'Записи', 'url' => $this->createUrl('/blog/admin/post/index')];
        if ($model->category) {
            $this->admin[] = ['label' => 'Редактировать категорию', 'url' => $this->createUrl('admin/category/update', ['id' => $model->category_id])];
        }
    }
    if (Yii::app()->moduleManager->allowed('comment')) {
        $this->admin[] = ['label' => 'Комментарии (' . $model->comments_new_count . ' ' . NumberHelper::Plural($model->comments_new_count, ['новый', 'новых', 'новых']) . ')', 'url' => $this->createUrl('/blog/admin/comment/index', ['id' => $model->id])];
    }
}

BlogPostAsset::register(Yii::$app->view);

CTextHighlighter::registerCssFile();

?>

<?php if (!$model->public) : ?>
    <div class="flash-error">Внимание! Новость скрыта от публикации!</div>
<?php endif; ?>

<article class="entry">
    <header>
        <h1><?php echo CHtml::encode($model->title); ?></h1>

        <!--noindex-->
        <?php if ($this->beginCache('banner_post_before', ['dependency' => new Tags('block')])) : ?>
            <?php $this->widget(\app\modules\block\widgets\BlockWidget::class, ['id' => 'banner_post_before']); ?>
            <?php $this->endCache(); ?>
        <?php endif; ?>
        <!--/noindex-->

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
            <p class="thumb"><?php echo CHtml::image($model->imageUrl, $model->image_alt, $properties); ?></p>
        <?php endif; ?>

    </header>

    <div class="text">
        <?php echo $this->decodeWidgets($model->text_purified); ?>
    </div>

    <div class="clear"></div>

</article>

<aside>

    <?php if ($this->beginCache('banner_post_after', ['dependency' => new Tags('block')])) : ?>
        <?php $this->widget(\app\modules\block\widgets\BlockWidget::class, ['id' => 'banner_post_after']); ?>
        <?php $this->endCache(); ?>
    <?php endif; ?>

    <div class="subscribe-after-post">
        <p class="title">Не пропускайте новые статьи, бонусы и мастер-классы:</p>
        <div class="subscribe-form">
            <form method="post" action="//elisdn.justclick.ru/subscribe/process/?rid%5B0%5D=blog&tag=bottom" target="_blank">
                <div class="row">
                    <input type="text" name="lead_name" placeholder="Ваше имя" style="border-color: #aaa" required />
                </div>
                <div class="row">
                    <input type="email" name="lead_email" placeholder="Ваш Email" style="border-color: #aaa" required />
                </div>
                <div class="row button">
                    <input type="submit" name="submit" value="Подписаться" style="font-size: 13px" />
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
    <p class="entry_date">Дата: <span class="enc-date" data-date="<?php echo DateHelper::normdate($model->date); ?>">&nbsp;</span>
    </p>
    <p class="entry_tags">Метки: <?php echo implode('', $links); ?></p>
    <div class="clear"></div>
    <!--/noindex-->

    <div class="block-title">Поделиться</div>

    <div class="donate-btn"><a href="/donate">Поддержать проект</a></div>

    <?php $this->widget(\app\components\widgets\ShareWidget::class, [
        'title' => $model->title,
        'description' => $model->description,
        'image' => $model->imageUrl,
    ]); ?>

    <div class="clear"></div>

    <?php if ($this->beginCache(__FILE__ . __LINE__ . '_post_other_' . $model->id, ['dependency' => new Tags('blog')])) : ?>
        <?php $this->widget(\app\modules\blog\widgets\ThemePostsWidget::class, [
            'current' => $model->id,
            'group' => $model->group_id,
        ]); ?>
        <?php $this->endCache(); ?>
    <?php endif; ?>

    <?php if ($this->beginCache(__FILE__ . __LINE__ . '_post_other_' . $model->id, ['dependency' => new Tags('blog')])) : ?>
        <?php $this->widget(\app\modules\blog\widgets\OtherPostsWidget::class, [
            //'category'=>$model->category_id,
            'skip' => $model->id,
            'limit' => 2,
        ]); ?>
        <?php $this->endCache(); ?>
    <?php endif; ?>

</aside>

<?php $this->widget(\app\modules\comment\widgets\CommentsWidget::class, [
    'material_id' => $model->id,
    'authorId' => $model->author_id,
    'type' => Comment::TYPE_OF_COMMENT,
    'url' => $model->url,
]); ?>
