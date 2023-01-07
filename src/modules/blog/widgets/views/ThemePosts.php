<?php declare(strict_types=1);

use app\modules\blog\models\Post;
use yii\helpers\Url;

/**
 * @var Post[] $posts
 * @var int $current
 */
?>
<div class="block-title">Материалы по теме</div>
<ul style="list-style: none; margin-left: 0">
    <?php foreach ($posts as $item): ?>
        <?php if ($item->id !== $current): ?>
            <li><a href="<?= Url::to(['/blog/post/show', 'id' => $item->id, 'slug' => $item->slug]); ?>"><?= $item->title; ?></a></li>
        <?php else: ?>
            <li><?= $item->title; ?></li>
        <?php endif; ?>
    <?php endforeach; ?>
</ul>
