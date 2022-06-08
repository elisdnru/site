<?php declare(strict_types=1);

use app\components\DataProvider;
use app\components\DateFormatter;
use app\modules\blog\models\Post;
use yii\helpers\FileHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\LinkPager;

/** @var DataProvider<Post> $dataProvider */
?>

<div>
    <div class="items">
        <?php foreach ($dataProvider->getItems() as $post) : ?>
            <?php
            $links = [];
            foreach ($post->tags as $tag) {
                $links[] = '<a href="' . Url::to(['/blog/default/tag', 'tag' => $tag->title]) . '">' . Html::encode($tag->title) . '</a>';
            }
            ?>
            <div class="entry list">
                <div class="header">
                    <div class="title"><a href="<?= $post->getUrl(); ?>"><?= Html::encode($post->title); ?></a></div>
                    <!--noindex-->
                    <div class="info">
                        <div class="date">
                            <span class="enc-date" data-date="<?= DateFormatter::format($post->date); ?>">&nbsp;</span>
                        </div>
                        <div class="category">
                            <span><a href="<?= $post->category->getUrl(); ?>"><?= Html::encode($post->category->title); ?></a></span>
                        </div>
                        <?php if ($links) : ?>
                            <div class="tags"><span><?= implode(', ', $links); ?></span></div>
                        <?php endif; ?>
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
                            <a href="<?= $post->getUrl(); ?>">
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
                    <p><?= strip_tags($post->short); ?></p>
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
</div>
