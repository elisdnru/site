<?php
/** @var $group \app\modules\blog\models\Group */
/** @var $current int */
?>
<br />
<h4>Материалы по теме:</h4>
<ul style="list-style: none; margin: 0">
    <?php foreach ($group->posts as $item) : ?>
        <?php if ($item->id != $current) : ?>
            <li>&raquo; <a href="<?php echo $item->url ?>"><?php echo $item->title; ?></a></li>
        <?php else : ?>
            <li>&raquo; <?php echo $item->title; ?></li>
        <?php endif; ?>

    <?php endforeach; ?>
</ul>

