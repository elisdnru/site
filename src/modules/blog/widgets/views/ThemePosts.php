<?php declare(strict_types=1);

use app\modules\blog\models\Post;

/**
 * @var Post[] $posts
 * @var int $current
 */
?>
<div class="block-title">Материалы по теме</div>
<ul style="list-style: none; margin-left: 0">
    <?php foreach ($posts as $item) : ?>
        <?php if ($item->id !== $current) : ?>
            <li><a href="<?= $item->getUrl(); ?>"><?= $item->title; ?></a></li>
        <?php else : ?>
            <li><?= $item->title; ?></li>
        <?php endif; ?>
    <?php endforeach; ?>
</ul>
