<?php
/** @var $data Post */

use app\modules\blog\models\Post;
use app\components\helpers\DateHelper;

$links = [];
foreach ($data->cache(1000)->tags as $tag) {
    $links[] = '<a href="' . CHtml::encode($tag->url) . '">' . CHtml::encode($tag->title) . '</a>';
}
?>

<div class="entry list">
    <div class="header">
        <div class="title"><a href="<?= $data->url ?>"><?= CHtml::encode($data->title) ?></a></div>
        <!--noindex-->
        <div class="info">
            <div class="date">
                <span class="enc-date" data-date="<?= DateHelper::normdate($data->date) ?>">&nbsp;</span>
            </div>
            <?php if ($data->category) : ?>
                <div class="category">
                    <span><a href="<?= $data->category->url ?>"><?= CHtml::encode($data->category->title) ?></a></span>
                </div>
            <?php endif; ?>
            <div class="tags"><span><?= implode(', ', $links) ?></span></div>
            <div class="comments">
                <span><a href="<?= $data->url ?>#comments"><?= $data->commentsCount ?></a></span>
            </div>
        </div>
        <?php if ($data->image) : ?>
            <?php $imageUrl = $data->getImageThumbUrl(250); ?>
            <?php
            $properties = [];
            if ($data->image_width) {
                $properties['width'] = $data->image_width;
            }
            if ($data->image_height) {
                $properties['height'] = $data->image_height;
            }
            ?>
            <div class="thumb">
                <a href="<?= $data->url ?>">
                    <picture>
                        <source srcset="<?= $imageUrl ?>.webp" type="image/webp">
                        <source srcset="<?= $imageUrl ?>" type="image/jpeg">
                        <?= CHtml::image($imageUrl, $data->image_alt, $properties) ?>
                    </picture>
                </a>
            </div>
        <?php endif; ?>
        <!--/noindex-->
    </div>
    <div class="short"><?= trim($data->short_purified) ?></div>
    <!--noindex-->
    <div class="more"><a href="<?= $data->url ?>">Читать далее</a></div>
    <!--/noindex-->
    <div class="clear"></div>
</div>
