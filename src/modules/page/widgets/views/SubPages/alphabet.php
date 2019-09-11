<?php $oldletter = ''; ?>
<div class="alphabet_list">
    <ul>
        <?php foreach ($pages

        as $page) : ?>
        <?php $letter = mb_substr($page->title, 0, 1, 'UTF-8'); ?>

        <?php if ($letter != $oldletter) : ?>
    </ul>
    <p class="letter"><?php echo $letter; ?></p>
    <ul>
        <?php endif; ?>

        <li><a href="<?php echo $page->url; ?>"><?php echo $page->title; ?></a></li>

        <?php $oldletter = $letter; ?>

        <?php endforeach; ?>
    </ul>
</div>
