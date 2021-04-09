<?php

use app\modules\page\models\Page;
use yii\caching\TagDependency;
use yii\helpers\Html;
use yii\web\View;

/**
 * @var View $this
 * @var Page $page
 */
?>
<?php if ($this->beginCache(__FILE__ . __LINE__ . '_tabs_' . $page->id, ['dependency' => new TagDependency(['tags' => 'page'])])) : ?>
    <?php if ($page->parent) : ?>
        <?php if (!$page->hidetitle) : ?>
            <h1><?= Html::a($page->parent->title, $page->parent->getUrl()) ?></h1>
        <?php endif; ?>

        <div class="subpages">
            <ul>
                <?php foreach ($page->parent->children as $child) : ?>
                    <?php $url = $child->getUrl(); ?>
                    <?php if (Yii::$app->request->getPathInfo() === $url) : ?>
                        <li class="active"><a href="<?= $url ?>"><?= $child->title ?></a></li>
                    <?php else : ?>
                        <li><a href="<?= $url ?>"><?= $child->title ?></a></li>
                    <?php endif; ?>
                <?php endforeach; ?>
            </ul>
            <div class="clear"></div>
        </div>

    <?php elseif ($page->children) : ?>
        <?php if (!$page->hidetitle) : ?>
            <h1><?= $page->title ?></h1>
        <?php endif; ?>

        <div class="subpages">
            <ul>
                <?php foreach ($page->children as $child) : ?>
                    <li><a href="<?= $child->getUrl() ?>"><?= $child->title ?></a></li>
                <?php endforeach; ?>
            </ul>
            <div class="clear"></div>
        </div>

    <?php else : ?>
        <?php if (!$page->hidetitle) : ?>
            <h1><?= $page->title ?></h1>
        <?php endif; ?>

    <?php endif; ?>
    <div class="clear"></div>
    <?php $this->endCache(); ?>
<?php endif; ?>
<!-- /Подстраницы (табы) -->
