<?php
use app\extensions\cachetagging\Tags;
use app\modules\main\components\DController;
use app\modules\menu\models\Menu;
use app\modules\user\models\Access;

/** @var $this DController */
?><!doctype html>
<html lang="<?php echo Yii::app()->language; ?>">
<head>
    <?php if (!$this->is(Access::ROLE_ADMIN)) : ?>
        <script language="JavaScript" type="text/javascript" src="//elisdn.justclick.ru/jsapi/click.js"></script>
    <?php endif; ?>

    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width">
    <meta name="webmoney.attestation.label" content="webmoney attestation label#52154DE9-6E16-41B7-A8EF-3214D8E53DAB" />

    <meta name="description" content="<?php echo CHtml::encode($this->description); ?>" />
    <meta name="keywords" content="<?php echo CHtml::encode($this->keywords); ?>" />

    <link rel="shortcut icon" href="/favicon.ico" />
    <link rel="alternate" type="application/rss+xml" title="Дмитрий Елисеев" href="https://feeds.feedburner.com/elisdn" />
    <link rel="canonical" href="<?php echo Yii::app()->request->getHostInfo() . '/' . preg_replace('#/page-\d+#', '', Yii::app()->request->getPathInfo()); ?>" />

    <link type="text/css" rel="stylesheet" href="/build/main.css?v=<?php echo @filemtime(Yii::getPathOfAlias('webroot') . '/build/main.css'); ?>" />
    <?php Yii::app()->clientScript->registerCoreScript('jquery'); ?>
    <?php Yii::app()->clientScript->registerScriptFile('/build/main.js?v=' . @filemtime(Yii::getPathOfAlias('webroot') . '/build/main.js')); ?>
    <?php Yii::app()->clientScript->registerScriptFile('core-end.js', CClientScript::POS_END); ?>
    <title><?php echo CHtml::encode($this->pageTitle); ?></title>

</head>
<body>

<div id="wrapper">

    <header id="header">
        <?php if ($this->route != 'main/default/index') :
        ?><!--noindex--><?php
        endif; ?>
        <div class="logo">
        <span data-href="/">
            <img src="/images/logo.png" alt="<?php echo Yii::app()->params['GENERAL.SITE_NAME']; ?>" />
        </span>
        </div>
        <div class="slogan">
            <p>Дмитрий Елисеев</p>
            <p>Разработка сайтов и интернет-сервисов</p>
        </div>
        <?php if ($this->route != 'main/default/index') :
        ?><!--/noindex--><?php
    endif; ?>

        <div class="search">
            <?php $this->widget(\app\modules\search\widgets\SearchFormWidget::class); ?>
        </div>

        <nav id="main_nav">
            <?php $this->widget('zii.widgets.CMenu', [
                'items' => Menu::model()->cache(0, new Tags('menu'))->getMenuList('main-menu')]); ?>
        </nav>
    </header>

    <?php if (count($this->admin)) : ?>
        <div class="adminbar">
            <?php $this->widget(\app\modules\main\components\widgets\DAdminlinksWidget::class, [
                'links' => $this->admin,
                'info' => $this->info
            ]); ?>
        </div>
    <?php endif; ?>

    <div id="content">

        <?php if (Yii::app()->user->hasFlash('email')) : ?>
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
            <?php if (!$this->is(Access::ROLE_ADMIN)) : ?>
                <?php $this->renderPartial('//layouts/_counters'); ?>
            <?php endif; ?>
        </div>

        <!--noindex-->
        <div class="nav">
            <?php $this->beginWidget(\app\modules\main\components\widgets\DNofollowWidget::class); ?>
            <?php $this->widget('zii.widgets.CMenu', [
                'items' => Menu::model()->cache(0, new Tags('menu'))->getMenuList('main-menu')]); ?>
            <?php $this->endWidget(); ?>
        </div>
        <!--/noindex-->

        <div class="system_nav">
            <?php if (Yii::app()->request->getPathInfo() != 'sitemap') : ?>
                <a href="/sitemap">Карта сайта</a>
            <?php else : ?>
                <span data-href="/sitemap">Карта сайта</span>
            <?php endif; ?>
        </div>

        <?php if ($this->route != 'main/default/index') :
        ?><!--noindex--><?php
        endif; ?>
        <div class="info">
            <p>
                © ИП Елисеев Дмитрий Николаевич</span>, 2009-<?php echo date('Y') ?><br />
                ОГРН: 309574636200019; ИНН: 570600870325<br />
                <a rel="nofollow" href="/privacy">Политика конфиденциальности</a><br />
                Email:
                <script>document.write('<a rel="nofollow" href="mailto:mai' + 'l@el' + 'isdn.ru">ma' + 'il@e' + 'lisdn.ru</a>')</script>
            </p>
        </div>
        <?php if ($this->route != 'main/default/index') :
        ?><!--/noindex--><?php
    endif; ?>

        <!--noindex-->
        <div class="copy">
            <p>
                Права на все материалы, опубликованные на сайте, принадлежат автору.<br />
                Незаконное копирование материалов преследуется по закону.<br />
                Использование материалов возможно лишь при наличии<br />
                активной ссылки на источник. <a rel="nofollow" href="/copyright">Использование материалов</a>
            </p>
        </div>
        <!--/noindex-->

        <div class="clear"></div>
    </div>
</footer>

<!-- <?php echo sprintf('%0.3f', Yii::getLogger()->getExecutionTime()) ?>с. <?php echo round(memory_get_peak_usage() / (1024 * 1024), 2) . "MB" ?> -->

</body>
</html>
