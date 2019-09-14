<?php
$this->pageTitle = 'Error';
$this->breadcrumbs = [
    'Ошибка ' . (isset($error['code']) ? $error['code'] : ''),
];
?>

<?php if ($this->is(Access::ROLE_CONTROL)) {
    $this->admin[] = ['label' => 'Вернуться на сайт', 'url' => '/index'];
    $this->info = 'Страница ошибки';
} ?>

<h2>Ошибка <?php echo isset($error['code']) ? $error['code'] : ''; ?></h2>

<?php if (YII_DEBUG) : ?>
    <p><?php echo isset($error['message']) ? CHtml::encode($error['message']) : ''; ?></p>

    <p>File: <?php echo isset($error['file']) ? CHtml::encode($error['file']) : ''; ?></p>
    <p>Line: <?php echo isset($error['line']) ? CHtml::encode($error['line']) : ''; ?></p>
<?php endif; ?>

<?php echo $this->decodeWidgets(trim($page->text_purified)); ?>
