<?php declare(strict_types=1);

use app\components\CSSMinimizer;
use app\modules\page\models\Page;
use app\widgets\Shortcodes;
use yii\web\View;

/**
 * @var View $this
 * @var Page $page
 * @var string $subpages_layout
 */
if ($page->styles) {
    $this->registerCss(CSSMinimizer::minimize(strip_tags($page->styles)));
}
?>
<?php if ($page->layout === 'blank') :
    ?><?php Shortcodes::begin(); ?><?= $page->text_purified; ?><?php Shortcodes::end(); ?><?php
else : ?>
    <section>
        <header>
            <?= $this->render('_head', ['page' => $page]); ?>
            <?= $this->render($subpages_layout, ['page' => $page]); ?>
        </header>

        <div class="text">
            <?php Shortcodes::begin(); ?>
            <?= $page->text_purified; ?>
            <?php Shortcodes::end(); ?>
        </div>
    </section>

<?php endif; ?>
