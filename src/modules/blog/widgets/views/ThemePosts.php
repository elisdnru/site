<?php declare(strict_types=1);

use app\modules\blog\models\Post;

/**
 * @var Post[] $posts
 * @var int $current
 */
?>
<br />
<h4>Материалы по теме:</h4>
<ul style="list-style: none; margin: 0">
    <?php foreach ($posts as $item) : ?>
        <?php if ($item->id !== $current) : ?>
            <li>&raquo; <a href="<?= $item->getUrl(); ?>"><?= $item->title; ?></a></li>
        <?php else : ?>
            <li>&raquo; <?= $item->title; ?></li>
        <?php endif; ?>
    <?php endforeach; ?>
</ul>

