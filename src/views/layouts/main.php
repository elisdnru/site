<?php /** @var $this DController */ ?><!doctype html>
<html lang="<?php echo Yii::app()->language; ?>">
<head>
<script language="JavaScript" type="text/javascript">var my_hop_host = 'elisdn.justclick.ru';</script>
<script language="JavaScript" type="text/javascript" src="//elisdn.justclick.ru/jsapi/click.js"></script>

<meta charset="utf-8" />
<meta name="viewport" content="width=device-width">
<meta name="webmoney.attestation.label" content="webmoney attestation label#52154DE9-6E16-41B7-A8EF-3214D8E53DAB" />

<meta name="description" content="<?php echo CHtml::encode($this->description); ?>" />
<meta name="keywords" content="<?php echo CHtml::encode($this->keywords); ?>" />

<link rel="shortcut icon" href="<?php echo Yii::app()->request->baseUrl; ?>/favicon.ico" />
<link rel="alternate" type="application/rss+xml" title="<?php echo CHtml::encode(Yii::app()->config->get('GENERAL.FEED_TITLE')); ?>" href="<?php echo Yii::app()->config->get('GENERAL.FEED_URL'); ?>" />
<?php if ($this->route == 'main/default/index'): ?>
<link rel="author" href="https://plus.google.com/116153200022401064957" />
<?php endif; ?>
<link rel="publisher" href="https://plus.google.com/116153200022401064957" />
<link rel="canonical" href="<?php echo Yii::app()->request->getHostInfo() . '/' . preg_replace('#/page-\d+#', '', Yii::app()->request->getPathInfo()); ?>" />

<link type="text/css" rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/css/system.css" />
<link type="text/css" rel="stylesheet" href="<?php echo Yii::app()->baseUrl; ?>/build/all-<?php echo @filemtime(Yii::getPathOfAlias('webroot') . '/build/main.css'); ?>.css" />
<!--[if lt IE 9]><script src="<?php echo Yii::app()->request->baseUrl; ?>/js/html5.js"></script><![endif]-->
<?php Yii::app()->clientScript->registerCoreScript('jquery'); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/build/all-' . @filemtime(Yii::getPathOfAlias('webroot') . '/build/main.css') . '.js'); ?>
<?php Yii::app()->clientScript->registerScriptFile('core-end.js', CClientScript::POS_END); ?>
<title><?php echo CHtml::encode($this->pageTitle); ?></title>

</head>
<body>

<div id="wrapper">

<header id="header">
	<?php if ($this->route != 'main/default/index'): ?><!--noindex--><?php endif; ?>
	<div class="logo">
		<span data-href="<?php echo Yii::app()->request->baseUrl; ?>/">
			<img src="<?php echo Yii::app()->baseUrl; ?>/images/logo.png" alt="<?php echo Yii::app()->config->get('GENERAL.SITE_NAME'); ?>" />
		</span>
	</div>
	<div class="slogan"><?php $this->widget('block.widgets.BlockWidget',array('id'=>'header')); ?></div>
	<?php if ($this->route != 'main/default/index'): ?><!--/noindex--><?php endif; ?>

	<div class="search">
		<?php $this->widget('search.widgets.SearchFormWidget'); ?>
	</div>

    <nav id="main_nav">
        <?php Yii::import('menu.models.*'); ?>

        <?php $this->widget('zii.widgets.CMenu',array(
            'items'=>Menu::model()->cache(0, new Tags('menu'))->getMenuList('main-menu'))
        ); ?>
    </nav>
</header>

    <?php  if(count($this->admin)) : ?>
    <div class="adminbar">
        <?php $this->widget('DAdminlinksWidget', array(
        'links'=>$this->admin,
        'info'=>$this->info
    )); ?>
    </div>
    <?php endif; ?>

<div id="content">

    <?php if(Yii::app()->user->hasFlash('email')): ?>
        <!-- Отладка мэйлера -->
        <div class="flash-success">
            <?php echo Yii::app()->user->getFlash('email'); ?>
        </div>
        <!-- /Отладка мэйлера -->
    <?php endif; ?>

<!-- Контент -->
<?php echo $content; ?>
<!-- /Контент -->

    <div class="clear"></div>

</div>
<div id="clearfooter"></div>
</div>
<footer id="footer">
    <div class="content">

        <div class="counters">
            <?php if (!$this->is(Access::ROLE_ADMIN)): ?>
                <?php $this->widget('block.widgets.BlockWidget',array('id'=>'counters')); ?>
            <?php endif; ?>

        </div>

        <!--noindex-->
        <div class="nav">
            <?php $this->beginWidget('DNofollowWidget'); ?>
            <?php $this->widget('zii.widgets.CMenu',array(
                    'items'=>Menu::model()->cache(0, new Tags('menu'))->getMenuList('main-menu'))
            ); ?>
            <?php $this->endWidget(); ?>
        </div>
        <!--/noindex-->

        <div class="system_nav">
            <?php if (Yii::app()->request->getPathInfo() != 'sitemap'): ?>
                <a href="/sitemap">Карта сайта</a>
            <?php else: ?>
                <span data-href="/sitemap">Карта сайта</span>
            <?php endif; ?>
        </div>

        <?php if ($this->route != 'main/default/index'): ?><!--noindex--><?php endif; ?>
        <div class="info"><?php $this->widget('block.widgets.BlockWidget',array('id'=>'footer')); ?></div>
        <?php if ($this->route != 'main/default/index'): ?><!--/noindex--><?php endif; ?>

        <!--noindex-->
        <div class="copy"><?php $this->widget('block.widgets.BlockWidget',array('id'=>'copyright')); ?></div>
        <!--/noindex-->

        <div class="clear"></div>
    </div>
</footer>

<!-- <?php echo sprintf('%0.3f',Yii::getLogger()->getExecutionTime()) ?>с. <?php echo round(memory_get_peak_usage()/(1024*1024),2)."MB" ?> -->

</body>
</html>
