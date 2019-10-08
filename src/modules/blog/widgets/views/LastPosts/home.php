<?php use app\components\helpers\DateHelper;

foreach ($posts as $data) : ?>
    <?php
    $links = [];
    foreach ($data->cache(1000)->tags as $tag) {
        $links[] = '<a href="' . CHtml::encode($tag->url) . '">' . CHtml::encode($tag->title) . '</a>';
    }
    ?>

    <div class="entry list">
        <div class="header">
            <div class="title"><a href="<?php echo $data->url; ?>"><?php echo CHtml::encode($data->title); ?></a></div>
            <!--noindex-->
            <div class="info">
                <p class="date">
                    <span class="enc-date" data-date="<?php echo DateHelper::normdate($data->date); ?>">&nbsp;</span>
                </p>
                <?php if ($data->category) : ?>
                    <p class="category">
                        <span><a href="<?php echo $data->category->url; ?>"><?php echo CHtml::encode($data->category->title); ?></a></span>
                    </p>
                <?php endif; ?>
                <p class="tags"><span><?php echo implode(', ', $links); ?></span></p>
                <p class="comments">
                    <span><a href="<?php echo $data->url; ?>#comments"><?php echo $data->comments_count; ?></a></span>
                </p>
            </div>
            <?php if ($data->image) : ?>
                <?php $imageUrl = $data->getImageThumbUrl(250, 0); ?>
                <?php
                $properties = [
                    'data-src' => $imageUrl
                ];
                if ($data->image_width) {
                    $properties['width'] = $data->image_width;
                }
                if ($data->image_height) {
                    $properties['height'] = $data->image_height;
                }
                ?>
                <p class="thumb">
                    <a href="<?php echo $data->url; ?>">
                        <picture>
                            <source srcset="/images/lazy/blank.webp" data-srcset="<?= $imageUrl ?>.webp" type="image/webp">
                            <source srcset="/images/lazy/blank.jpg" data-srcset="<?= $imageUrl ?>" type="image/jpeg">
                            <?php echo CHtml::image($imageUrl, '', $properties); ?>
                        </picture>
                    </a>
                </p>
            <?php endif; ?>
            <!--/noindex-->
        </div>
        <div class="short"><?php echo trim($data->short_purified); ?></div>
        <!--noindex--><p class="more"><a href="<?php echo $data->url; ?>">Читать далее</a></p><!--/noindex-->
    </div>

<?php endforeach; ?>
