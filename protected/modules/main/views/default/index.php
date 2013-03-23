<?php
$this->pageTitle = $page->pagetitle;
$this->description = $page->description;
$this->keywords = $page->keywords;

$this->isHomePage = true;

if ($this->is(Access::ROLE_CONTROL)){
    if ($this->moduleAllowed('contact')) $this->admin = array_merge($this->admin, Yii::app()->moduleManager->notifications('contact'));
    if ($this->moduleAllowed('comment')) $this->admin = array_merge($this->admin, Yii::app()->moduleManager->notifications('comment'));
    if ($this->moduleAllowed('shop')) $this->admin = array_merge($this->admin, Yii::app()->moduleManager->notifications('shop'));
    if ($this->moduleAllowed('callme')) $this->admin = array_merge($this->admin, Yii::app()->moduleManager->notifications('callme'));
	if ($this->moduleAllowed('page')) if ($page->id) $this->admin[] = array('label'=>'Редактировать страницу', 'url'=>$this->createUrl('/page/pageAdmin/update', array('id'=>$page->id)));
    $this->info = 'Стартовая страница';
}
?>

<?php if (!$page->hidetitle) : ?>
<h1><?php echo $page->title; ?></h1>
<?php endif; ?>

<?php echo $this->decodeWidgets(trim($page->text_purified)); ?>