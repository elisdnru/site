<?php declare(strict_types=1);

use app\assets\MainAsset;
use app\modules\block\widgets\BlockWidget;
use app\modules\blog\widgets\SearchFormWidget;
use app\modules\user\models\Access;
use app\widgets\AdminBar;
use app\widgets\Counters;
use app\widgets\MainMenu;
use app\widgets\NotificationBar;
use yii\caching\TagDependency;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;

/**
 * @var View $this
 * @var string $content
 */
MainAsset::register($this);

$this->registerLinkTag(['rel' => 'canonical', 'href' => Url::canonical()]);

?>
<?php $this->beginPage(); ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language; ?>">
<head>
    <?php if (!Yii::$app->user->can(Access::ROLE_ADMIN)): ?>
        <script src="//elisdn.justclick.ru/jsapi/click.js" async></script>
    <?php endif; ?>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="webmoney.attestation.label" content="webmoney attestation label#52154DE9-6E16-41B7-A8EF-3214D8E53DAB">
    <?= Html::csrfMetaTags(); ?>

    <link rel="shortcut icon" href="/favicon.ico">
    <link rel="alternate" type="application/rss+xml" title="Дмитрий Елисеев" href="https://feeds.feedburner.com/elisdn">

    <?php $this->head(); ?>

    <title><?= Html::encode($this->title); ?></title>
</head>
<body>
<?php $this->beginBody(); ?>

<?= NotificationBar::widget(); ?>

<div class="page-wrapper">

    <header class="page-header">
        <?php if ($this->context->route !== 'home/default/index') :
            ?><!--noindex--><?php
        endif; ?>
        <div class="logo">
        <a href="/">
            <img src="/images/logo.png" alt="ElisDN">
        </a>
        </div>
        <div class="title">
            <?php if ($this->context->route === 'home/default/index'): ?>
                <h1 class="name">Дмитрий Елисеев</h1>
            <?php else: ?>
                <div class="name">Дмитрий Елисеев</div>
            <?php endif; ?>
            <div class="slogan">о разработке сайтов и сервисов</div>
        </div>
        <?php if ($this->context->route !== 'home/default/index') :
            ?><!--/noindex--><?php
        endif; ?>

        <div class="search">
            <?= SearchFormWidget::widget(); ?>
        </div>

        <nav class="main-nav">
            <?= MainMenu::widget(); ?>
        </nav>
    </header>

    <?php if (count($this->params['admin'] ?? [])): ?>
        <div class="admin-bar">
            <?= AdminBar::widget([
                'links' => $this->params['admin'],
            ]); ?>
        </div>
    <?php endif; ?>

    <div class="page-content">

        <?= $content; ?>

        <div class="clear"></div>
    </div>
</div>

<footer class="page-footer">
    <div class="content">

        <div class="counters"></div>

        <!--noindex-->
        <div class="nav">
            <?= MainMenu::widget(['id' => 'footer_nav_list']); ?>
        </div>
        <!--/noindex-->

        <div class="system-nav">
            <?php if (Yii::$app->request->getPathInfo() !== 'sitemap'): ?>
                <a href="/sitemap">Карта сайта</a>
            <?php else: ?>
                <span>Карта сайта</span>
            <?php endif; ?>
        </div>

        <?php if ($this->context->route !== 'home/default/index'): ?>
            <!--noindex-->
        <?php endif; ?>
        <div class="info">
            <p>
                © ИП Елисеев Дмитрий Николаевич, 2009-<?= date('Y'); ?><br />
                ОГРН: 309574636200019; ИНН: 570600870325<br />
                <a rel="nofollow" href="/privacy">Политика конфиденциальности</a><br />
                Email:
                <script>document.write('<a rel="nofollow" href="mailto:mai' + 'l@el' + 'isdn.ru">ma' + 'il@e' + 'lisdn.ru</a>')</script>
            </p>
        </div>
        <?php if ($this->context->route !== 'home/default/index'): ?>
            <!--/noindex-->
        <?php endif; ?>

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

<?php $this->endBody(); ?>

<?= Counters::widget(); ?>

<?php if ($this->beginCache(__FILE__ . __LINE__, ['dependency' => new TagDependency(['tags' => 'block'])])): ?>
    <?= BlockWidget::widget(['id' => 'end']); ?>
    <?php $this->endCache(); ?>
<?php endif; ?>

<!-- <?= sprintf('%0.3f', Yii::getLogger()->getElapsedTime()); ?>s. <?= round(memory_get_peak_usage() / (1024 * 1024), 2) . 'MB'; ?> -->

</body>
</html>
<?php $this->endPage(); ?>
