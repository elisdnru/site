<?php

use app\components\CSSMinimizer;
use app\components\InlineWidgetsBehavior;
use app\modules\page\models\Page;
use yii\web\View;

/**
 * @var View|InlineWidgetsBehavior $this
 * @psalm-var View&InlineWidgetsBehavior $this
 * @var Page $page
 * @var string $subpages_layout
 */

if ($page->styles) {
    $this->registerCss(CSSMinimizer::minimize(strip_tags($page->styles)));
}
?>
<?php if ($page->layout === 'blank') :
    ?><?= $this->decodeWidgets($page->text_purified) ?><?php
else : ?>
    <section>
        <header>
            <?= $this->render('_head', ['page' => $page]) ?>
            <?= $this->render($subpages_layout, ['page' => $page]) ?>
        </header>

        <div class="text">
            <?= $this->decodeWidgets($page->text_purified) ?>
        </div>
    </section>

<?php endif; ?>
