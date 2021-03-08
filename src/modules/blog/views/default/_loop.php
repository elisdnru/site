<?php
use app\components\DateFormatter;
use app\modules\blog\models\Post;
use yii\data\ActiveDataProvider;
use yii\helpers\Html;
use yii\widgets\LinkPager;

/** @var ActiveDataProvider $dataProvider */
?>

<div>
    <div class="items">
        <?php foreach ($dataProvider->getModels() as $post) : ?>
            <?php /** @var Post $post */ ?>
            <?php
            $links = [];
            foreach ($post->tags as $tag) {
                $links[] = '<a href="' . Html::encode($tag->getUrl()) . '">' . Html::encode($tag->title) . '</a>';
            }
            ?>
            <div class="entry list">
                <div class="header">
                    <div class="title"><a href="<?= $post->getUrl() ?>"><?= Html::encode($post->title) ?></a></div>
                    <!--noindex-->
                    <div class="info">
                        <div class="date">
                            <span class="enc-date" data-date="<?= DateFormatter::format($post->date) ?>">&nbsp;</span>
                        </div>
                        <div class="category">
                            <span><a href="<?= $post->category->getUrl() ?>"><?= Html::encode($post->category->title) ?></a></span>
                        </div>
                        <div class="tags"><span><?= implode(', ', $links) ?></span></div>
                        <div class="comments">
                            <span><?= $post->getCommentsCount() ?></span>
                        </div>
                    </div>
                    <?php if ($post->image) : ?>
                        <?php $imageUrl = $post->getImageThumbUrl(250); ?>
                        <?php
                        $properties = [
                            'alt' => $post->image_alt,
                        ];
                        if ($post->image_width) {
                            $properties['width'] = $post->image_width;
                        }
                        if ($post->image_height) {
                            $properties['height'] = $post->image_height;
                        }
                        ?>
                        <div class="thumb">
                            <a href="<?= $post->getUrl() ?>">
                                <picture>
                                    <source srcset="<?= $imageUrl ?>.webp" type="image/webp">
                                    <source srcset="<?= $imageUrl ?>" type="image/jpeg">
                                    <?= Html::img($imageUrl, $properties) ?>
                                </picture>
                            </a>
                        </div>
                    <?php endif; ?>
                    <!--/noindex-->
                </div>
                <div class="short"><?= trim($post->short_purified) ?></div>
                <div class="clear"></div>
            </div>
        <?php endforeach; ?>
    </div>
    <div class="pager">
        <?= LinkPager::widget([
            'pagination' => $dataProvider->getPagination(),
        ]) ?>
    </div>
</div>
