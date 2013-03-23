<div class="<?php echo $class; ?>">
    <ul>
        <?php foreach ($friends as $friend): ?>
        <li><?php echo CHtml::encode($friend->user->username); ?></li>
        <?php endforeach; ?>
    </ul>

    <?php if ($user->id == Yii::app()->user->id): ?>
        <p><?php echo CHtml::link('Manage', '/forum/ucp.php?i=177'); ?></p>
    <?php endif; ?>
</div>