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

        <?php if (Yii::app()->request->getParam('page', 1) > 1) : ?>
            <noindex>
        <?php endif; ?>

        <div class="text">
            <?php echo $this->decodeWidgets($page->text_purified); ?>
        </div>

        <?php if (Yii::app()->request->getParam('page', 1) > 1) : ?>
            </noindex>
        <?php endif; ?>
    </section>

    <?php if ($this->beginCache(__FILE__ . __LINE__ . '_page_' . $page->id, ['dependency' => new Tags('blog')])) : ?>
        <?php foreach ($page->files as $file) : ?>
            <p><img src="/images/fileicon.jpg" alt="" />
                <a href="<?php echo '/' . PageFile::FILE_PATH . '/' . $file->file; ?>"><?php echo str_replace('_', ' ', $file->title); ?></a>
            </p>
        <?php endforeach; ?>
        <?php $this->endCache(); ?>
    <?php endif; ?>

    <?php if (preg_match('|<pre\sclass=\"brush\s?:\s?\w+\">|', $page->text)) : ?>
        <?php Yii::app()->syntaxHighlighter->addHighlighter(); ?>
    <?php endif; ?>

<?php endif; ?>
