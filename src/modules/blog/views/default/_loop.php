<?php
use app\components\helpers\DateHelper;
use yii\data\Pagination;
use yii\helpers\Html;
use yii\widgets\LinkPager;

/** @var $dataProvider CDataProvider */
?>

<div id="blogList">
    <div class="items">
        <?php foreach ($dataProvider->getData() as $post) : ?>
            <?php /** @var \app\modules\blog\models\Post $post */ ?>
            <?php
            $links = [];
            foreach ($post->cache(1000)->tags as $tag) {
                $links[] = '<a href="' . Html::encode($tag->url) . '">' . Html::encode($tag->title) . '</a>';
            }
            ?>
            <div class="entry list">
                <div class="header">
                    <div class="title"><a href="<?= $post->url ?>"><?= Html::encode($post->title) ?></a></div>
                    <!--noindex-->
                    <div class="info">
                        <div class="date">
                            <span class="enc-date" data-date="<?= DateHelper::normdate($post->date) ?>">&nbsp;</span>
                        </div>
                        <?php if ($post->category) : ?>
                            <div class="category">
                                <span><a href="<?= $post->category->url ?>"><?= Html::encode($post->category->title) ?></a></span>
                            </div>
                        <?php endif; ?>
                        <div class="tags"><span><?= implode(', ', $links) ?></span></div>
                        <div class="comments">
                            <span><?= $post->commentsCount ?></span>
                        </div>
                    </div>
                    <?php if ($post->image) : ?>
                        <?php $imageUrl = $post->getImageThumbUrl(250); ?>
                        <?php
                        $properties = [];
                        if ($post->image_width) {
                            $properties['width'] = $post->image_width;
                        }
                        if ($post->image_height) {
                            $properties['height'] = $post->image_height;
                        }
                        ?>
                        <div class="thumb">
                            <a href="<?= $post->url ?>">
                                <picture>
                                    <source srcset="<?= $imageUrl ?>.webp" type="image/webp">
                                    <source srcset="<?= $imageUrl ?>" type="image/jpeg">
                                    <?= CHtml::image($imageUrl, $post->image_alt, $properties) ?>
                                </picture>
                            </a>
                        </div>
                    <?php endif; ?>
                    <!--/noindex-->
                </div>
                <div class="short"><?= trim($post->short_purified) ?></div>
                <!--noindex-->
                <div class="more"><a href="<?= $post->url ?>">Читать далее</a></div>
                <!--/noindex-->
                <div class="clear"></div>
            </div>
        <?php endforeach; ?>
    </div>
    <div class="pager">
        <?= LinkPager::widget([
            'pagination' => new Pagination([
                'totalCount' => $dataProvider->getPagination()->getItemCount(),
                'defaultPageSize' => $dataProvider->getPagination()->getPageSize(),
                'forcePageParam' => false,
            ]),
        ]) ?>
    </div>
</div>
