<?php
/* @var $this Controller */

use app\extensions\cachetagging\Tags;
use app\modules\blog\models\BlogPost;
use app\modules\blog\models\BlogPostComment;
use app\modules\main\components\Controller;
use app\modules\main\components\helpers\DateHelper;
use app\modules\main\components\helpers\NumberHelper;
use app\modules\user\models\Access;

/* @var $model BlogPost */
/* @var $dataProvider CActiveDataProvider */

$this->pageTitle = $model->pagetitle;
$this->description = $model->description;
$this->keywords = ($model->category ? $model->category->title . ' ' : '') . implode(' ', CHtml::listData($model->tags, 'id', 'title')) . ($model->keywords ? ' ' . $model->keywords : '');

$this->breadcrumbs = [
    'Блог' => $this->createUrl('/blog')
];

$cs = Yii::app()->clientScript;
$cs->registerMetaTag($model->title, null, null, ['property' => 'og:title']);
$cs->registerMetaTag($model->description, null, null, ['property' => 'og:description']);
$cs->registerMetaTag(Yii::app()->request->getHostInfo() . $model->url, null, null, ['property' => 'og:url']);
if ($model->image) {
    $cs->registerMetaTag(Yii::app()->request->getHostInfo() . $model->imageUrl, null, null, ['property' => 'og:image']);
    $cs->registerLinkTag('image_src', null, Yii::app()->request->getHostInfo() . $model->imageUrl);
}

if ($model->category) {
    $this->breadcrumbs = array_merge($this->breadcrumbs, $model->category->getBreadcrumbs(true));
}

$this->breadcrumbs[] = $model->title;

if ($this->is(Access::ROLE_CONTROL)) {
    if ($this->moduleAllowed('blog')) {
        $this->admin[] = ['label' => 'Редактировать', 'url' => $this->createUrl('/blog/postAdmin/update', ['id' => $model->id])];
    }
    if ($this->moduleAllowed('blog')) {
        $this->admin[] = ['label' => 'Записи', 'url' => $this->createUrl('/blog/postAdmin/index')];
    }
    if ($this->moduleAllowed('blog') && $model->category) {
        $this->admin[] = ['label' => 'Редактировать категорию', 'url' => $this->createUrl('categoryAdmin/update', ['id' => $model->category_id])];
    }
    if ($this->moduleAllowed('comment')) {
        $this->admin[] = ['label' => 'Комментарии (' . $model->comments_new_count . ' ' . NumberHelper::Plural($model->comments_new_count, ['новый', 'новых', 'новых']) . ')', 'url' => $this->createUrl('/blog/commentAdmin/index', ['id' => $model->id])];
    }

    $this->info = 'Нажмите «Редактировать» чтобы изменить статью';
}

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
            <form method="post" action="//elisdn.justclick.ru/subscribe/process/?rid%5B0%5D=blog&tag=bottom" target="_blank"  onsubmit="return jc_chkscrfrm(this, false, false, false, false)">
                <div class="row">
                    <input type="text" name="lead_name" placeholder="Ваше имя" style="border-color: #aaa" />
                </div>
                <div class="row">
                    <input type="email" name="lead_email" placeholder="Ваш Email" style="border-color: #aaa" />
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
        $links[] = '<span data-href="' . CHtml::encode($tag->url) . '">' . CHtml::encode($tag->title) . '</span>';
    }
    ?>
    <p class="entry_date">Дата: <span class="enc-date" data-date="<?php echo DateHelper::normdate($model->date); ?>">&nbsp;</span>
    </p>
    <p class="entry_tags">Метки: <?php echo implode('', $links); ?></p>
    <div class="clear"></div>
    <!--/noindex-->

    <div class="donate-btn" style=""><a href="/donate">Поддержать проект</a></div>

    <?php $this->widget(\app\modules\share\widgets\ShareWidget::class, [
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
    'type' => BlogPostComment::TYPE_OF_COMMENT,
    'url' => $model->url,
]); ?>
