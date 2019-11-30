<?php $this->beginContent('@app/views/layouts/main.php');

use app\widgets\Messages; ?>

<div class="main left_main">

    <?= Messages::widget() ?>

    <?= $content ?>

</div>

<aside class="sidebar right_sidebar">

    <?= $this->render('/layouts/_sidebar'); ?>

    <div class="clear bottom-marker"></div>
</aside>

<?php $this->endContent(); ?>
