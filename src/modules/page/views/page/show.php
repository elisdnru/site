<?php

use app\components\helpers\StyleHelper;
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

        <div class="text">
            <?= $this->decodeWidgets($page->text_purified) ?>
        </div>
    </section>

<?php endif; ?>
