<?php

use app\modules\page\models\Page;

/**
 * @var Page $page
 */

?>
<?php if (!$page->hidetitle) : ?>
    <h1><?= $page->title ?></h1>
<?php endif; ?>
