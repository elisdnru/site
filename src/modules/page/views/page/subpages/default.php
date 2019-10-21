<?php
/** @var $page Page */

use app\modules\page\models\Page;

?>
<?php if (!$page->hidetitle) : ?>
    <h1><?php echo $page->title; ?></h1>
<?php endif; ?>
