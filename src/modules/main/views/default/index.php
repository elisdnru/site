<?php
/* @var $this DController */
/* @var $page Page */

$this->pageTitle = $page->pagetitle;
$this->description = $page->description;
$this->keywords = $page->keywords;

if ($this->is(Access::ROLE_CONTROL)) {
    if ($this->moduleAllowed('contact')) {
        $this->admin = array_merge($this->admin, Yii::app()->moduleManager->notifications('contact'));
    }
    if ($this->moduleAllowed('comment')) {
        $this->admin = array_merge($this->admin, Yii::app()->moduleManager->notifications('comment'));
    }
    if ($this->moduleAllowed('page')) {
        if ($page->id) {
            $this->admin[] = ['label' => 'Редактировать страницу', 'url' => $this->createUrl('/page/pageAdmin/update', ['id' => $page->id])];
        }
    }
    $this->info = 'Стартовая страница';
}
?>

<?php if (!$page->hidetitle) : ?>
    <h1><?php echo $page->title; ?></h1>
<?php endif; ?>

<?php echo $this->decodeWidgets(trim($page->text_purified)); ?>

<?php if (Yii::app()->moduleManager->active('blog')) : ?>
    <?php DUrlRulesHelper::import('blog'); ?>

    <h2 class="index">Новое в <a href="<?php echo $this->createUrl('/blog/default/index'); ?>">Блоге</a>:</h2>
    <?php if ($this->beginCache(__FILE__ . __LINE__, ['dependency' => new Tags('blog')])) : ?>
        <?php $this->widget('blog.widgets.LastPostsWidget', ['tpl' => 'home', 'limit' => Yii::app()->config->get('BLOG.POSTS_PER_HOME')]); ?>
        <?php $this->endCache(); ?>
    <?php endif; ?>

    <div class="clear"></div>
    <p class="nomargin"><span data-href="<?php echo $this->createUrl('/blog/default/index', ['page' => 2]); ?>">Остальные записи &rarr;</span>
    </p>

<?php endif; ?>