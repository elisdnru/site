<?php

use app\assets\MainAsset;
use app\components\widgets\AdminBarWidget;
use app\extensions\cachetagging\Tags;
use app\modules\menu\models\Menu;
use app\modules\search\widgets\SearchFormWidget;
use app\modules\user\models\Access;

MainAsset::register($this);

$this->registerMetaTag(['name' => 'csrf-token', 'content' => Yii::app()->request->csrfToken]);

/** @var $this \yii\web\View */
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::app()->language ?>">
<head>
    <?php if (!Yii::app()->user->checkAccess(Access::ROLE_ADMIN)) : ?>
        <script src="//elisdn.justclick.ru/jsapi/click.js" async></script>
    <?php endif; ?>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="webmoney.attestation.label" content="webmoney attestation label#52154DE9-6E16-41B7-A8EF-3214D8E53DAB">

    <link rel="shortcut icon" href="/favicon.ico">
    <link rel="alternate" type="application/rss+xml" title="Дмитрий Елисеев" href="https://feeds.feedburner.com/elisdn">
    <link rel="canonical" href="<?= Yii::app()->request->getHostInfo() . '/' . preg_replace('#/page-\d+#', '', Yii::app()->request->getPathInfo()) ?>">

    <?php $this->head() ?>

    <title><?= CHtml::encode($this->title) ?></title>
</head>
<body>
<?php $this->beginBody() ?>

<div id="wrapper">

    <header id="header">
        <?php if ($this->context->route !== 'main/default/index'): ?><!--noindex--><?php endif; ?>
        <div class="logo">
        <a href="/">
            <img src="/images/logo.png" alt="<?= Yii::app()->params['GENERAL.SITE_NAME'] ?>">
        </a>
        </div>
        <div class="title">
            <?php if ($this->context->route === 'main/default/index') : ?>
                <h1 class="name">Дмитрий Елисеев</h1>
            <?php else: ?>
                <div class="name">Дмитрий Елисеев</div>
            <?php endif; ?>
            <div class="slogan">Разработка сайтов и интернет-сервисов</div>
        </div>
        <?php if ($this->context->route !== 'main/default/index'): ?><!--/noindex--><?php
    endif; ?>

        <div class="search">
            <?= SearchFormWidget::widget() ?>
        </div>

        <nav id="main_nav">
            <?= \yii\widgets\Menu::widget([
                'id' => 'main_nav_list',
                'items' => Menu::model()->cache(0, new Tags('menu'))->getMenuList('main-menu')
            ]); ?>
        </nav>
    </header>

    <?php if (count($this->params['admin'] ?? [])) : ?>
        <div class="adminbar">
            <?= AdminBarWidget::widget([
                'links' => $this->params['admin'],
            ]) ?>
        </div>
    <?php endif; ?>

    <div id="content">

        <?= $content ?>

        <div class="clear"></div>
    </div>
</div>

<footer id="footer">
    <div class="content">

        <div class="counters">
            <?php if (!YII_DEBUG && !Yii::app()->user->checkAccess(Access::ROLE_ADMIN)) : ?>
                <?= $this->render('//layouts/_counters'); ?>
            <?php endif; ?>
        </div>

        <!--noindex-->
        <div class="nav">
            <?= \yii\widgets\Menu::widget([
                'id' => 'footer_nav_list',
                'items' => Menu::model()->cache(0, new Tags('menu'))->getMenuList('main-menu')
            ]) ?>
        </div>
        <!--/noindex-->

        <div class="system_nav">
            <?php if (Yii::app()->request->getPathInfo() !== 'sitemap') : ?>
                <a href="/sitemap">Карта сайта</a>
            <?php else : ?>
                <span>Карта сайта</span>
            <?php endif; ?>
        </div>

        <?php if ($this->context->route !== 'main/default/index'): ?><!--noindex--><?php
        endif; ?>
        <div class="info">
            <p>
                © ИП Елисеев Дмитрий Николаевич, 2009-<?php echo date('Y') ?><br />
                ОГРН: 309574636200019; ИНН: 570600870325<br />
                <a rel="nofollow" href="/privacy">Политика конфиденциальности</a><br />
                Email:
                <script>document.write('<a rel="nofollow" href="mailto:mai' + 'l@el' + 'isdn.ru">ma' + 'il@e' + 'lisdn.ru</a>')</script>
            </p>
        </div>
        <?php if ($this->context->route !== 'main/default/index'): ?><!--/noindex--><?php
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

<!-- <?php echo sprintf('%0.3f', Yii::getLogger()->getExecutionTime()) ?>s. <?php echo round(memory_get_peak_usage() / (1024 * 1024), 2) . 'MB' ?> -->

<?php $this->endBody() ?>

</body>
</html>
<?php $this->endPage() ?>

