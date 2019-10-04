<?php use app\extensions\cachetagging\Tags;
use app\modules\page\models\PageFile;

if ($page->layout->alias == 'blank') : ?>
    <?php echo $this->decodeWidgets($page->text_purified); ?>
<?php else : ?>
    <section>
        <header>
            <?php $this->renderPartial('_head', ['page' => $page]); ?>
            <?php $this->renderPartial($layout_subpages, ['page' => $page]); ?>
        </header>

        <?php if ($this->beginCache(__FILE__ . __LINE__ . '_page_' . $page->id, ['dependency' => new Tags('page')])) : ?>
            <?php if ($page->image) : ?>
                <p class="thumb"><a href="<?php echo $page->imageUrl; ?>">
                        <?php echo CHtml::image($page->imageThumbUrl, $page->image_alt, ['class' => 'page']); ?>
                    </a></p>

            <?php endif; ?>
            <?php $this->endCache(); ?>
        <?php endif; ?>

        <div class="text">
            <?php echo $this->decodeWidgets($page->text_purified); ?>
        </div>
    </section>

<?php endif; ?>
