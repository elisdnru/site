<?php $this->beginContent('//layouts/main'); ?>

    <section class="main" id="admin">

        <?php $this->widget('main.widgets.DBreadcrumbsWidget'); ?>
        <?php $this->widget('main.widgets.DMessagesWidget'); ?>

        <?php echo $content; ?>

    </section>

<?php $this->endContent(); ?>