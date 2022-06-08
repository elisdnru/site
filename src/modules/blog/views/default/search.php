<?php declare(strict_types=1);

use app\components\DataProvider;
use app\components\DateFormatter;
use app\components\PaginationFormatter;
use app\components\purifier\MarkdownWidget;
use app\components\purifier\PurifierWidget;
use app\components\shortcodes\Shortcodes;
use app\components\TextMarker;
use app\modules\blog\forms\SearchForm;
use app\modules\blog\models\Post;
use app\modules\blog\widgets\SearchFormWidget;
use app\modules\user\models\Access;
use yii\helpers\FileHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;
use yii\widgets\LinkPager;

/**
 * @var View $this
 * @var SearchForm $searchForm
 * @var DataProvider<Post> $dataProvider
 */
$this->context->layout = 'index';

$this->title = 'Поиск по записям' . PaginationFormatter::appendix($dataProvider->getPagination()->getPage() + 1);

$this->params['breadcrumbs'] = [
    'Блог' => ['/blog/default/index'],
    'Поиск',
];

if (Yii::$app->user->can(Access::CONTROL)) {
    if (Yii::$app->moduleAdminAccess->isGranted('blog')) {
        $this->params['admin'][] = ['label' => 'Редактировать записи', 'url' => ['/blog/admin/post']];
        $this->params['admin'][] = ['label' => 'Добавить запись', 'url' => ['/blog/admin/post/create']];
    }
}
?>

<h1>Поиск в блоге</h1>

<?= SearchFormWidget::widget(); ?>

<div class="items">
    <?php foreach ($dataProvider->getItems() as $post) : ?>
        <?php
        $links = [];
        foreach ($post->tags as $tag) {
            $links[] = '<a href="' . Url::to(['/blog/default/tag', 'tag' => $tag->title]) . '">' . Html::encode($tag->title) . '</a>';
        }
        $url = Url::to(['/blog/post/show', 'id' => $post->id, 'slug' => $post->slug]);
        ?>
        <div class="entry list">
            <div class="header">
                <div class="title">
                    <a href="<?= $url; ?>"><?= TextMarker::markFragment(strip_tags($post->title), $searchForm->q); ?></a>
                </div>
                <!--noindex-->
                <div class="info">
                    <div class="date">
                        <span class="enc-date" data-date="<?= DateFormatter::format($post->date); ?>">&nbsp;</span>
                    </div>
                    <div class="category">
                        <span><a href="<?= $post->category->getUrl(); ?>"><?= Html::encode($post->category->title); ?></a></span>
                    </div>
                    <div class="tags"><span><?= implode(', ', $links); ?></span></div>
                    <div class="comments">
                        <span><?= $post->getCommentsCount(); ?></span>
                    </div>
                </div>
                <?php if ($post->image) : ?>
                    <?php $imageUrl = $post->getImageThumbUrl(250, 0); ?>
                    <?php
                    $properties = [
                        'alt' => $post->image_alt,
                        'width' => 250,
                        'height' => 180,
                    ];
                    ?>
                    <div class="thumb">
                        <a href="<?= $url; ?>">
                            <picture>
                                <source srcset="<?= $imageUrl; ?>.webp" type="image/webp">
                                <source srcset="<?= $imageUrl; ?>" type="<?= FileHelper::getMimeTypeByExtension($imageUrl); ?>">
                                <?= Html::img($imageUrl, $properties); ?>
                            </picture>
                        </a>
                    </div>
                <?php endif; ?>
                <!--/noindex-->
            </div>
            <div class="short">
                <?php ob_start(); ?>
                <?php Shortcodes::begin(); ?>
                <?php PurifierWidget::begin(); ?>
                <?php MarkdownWidget::begin(); ?>
                <?= $post->text; ?>
                <?php MarkdownWidget::end(); ?>
                <?php PurifierWidget::end(); ?>
                <?php Shortcodes::end(); ?>
                <?php $text = ob_get_clean(); ?>
                <?= TextMarker::markFragment(strip_tags($text), $searchForm->q); ?>
                ...
            </div>
            <div class="clear"></div>
        </div>
    <?php endforeach; ?>
</div>
<div class="pager">
    <?= LinkPager::widget([
        'pagination' => $dataProvider->getPagination(),
    ]); ?>
</div>
