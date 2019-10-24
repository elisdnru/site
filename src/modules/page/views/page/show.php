<?php

use app\components\helpers\StyleHelper;
use app\extensions\cachetagging\Tags;
use app\modules\page\models\Page;

/** @var $page Page */
/** @var $subpages_layout string */

if ($page->styles) {
    $this->registerCss(StyleHelper::minimize(strip_tags($page->styles)));
}
?>
<?php if ($page->layout === 'blank') : ?><?= $this->decodeWidgets($page->text_purified) ?><?php else : ?>
    <section>
        <header>
            <?= $this->renderPartial('_head', ['page' => $page]); ?>
            <?= $this->renderPartial($subpages_layout, ['page' => $page]); ?>
        </header>

        <?php if ($this->beginCache(__FILE__ . __LINE__ . '_page_' . $page->id, ['dependency' => new Tags('page')])) : ?>
            <?php if ($page->image) : ?>
                <p class="thumb"><a href="<?= $page->imageUrl ?>">
                        <?= CHtml::image($page->imageThumbUrl, $page->image_alt, ['class' => 'page']) ?>
                    </a></p>

            <?php endif; ?>
            <?php $this->endCache(); ?>
        <?php endif; ?>

        <div class="text">
            <?= $this->decodeWidgets($page->text_purified) ?>
        </div>
    </section>

<?php endif; ?>
