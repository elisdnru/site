<!-- Подстраницы (табы) -->
<?php
use app\modules\page\models\Page;
use yii\caching\TagDependency;

/** @var $page Page */
?>
<?php if ($this->beginCache(__FILE__ . __LINE__ . '_tabs_' . $page->id, ['dependency' => new TagDependency(['tags' => 'page'])])) : ?>
    <?php if ($page->parent) : ?>
        <?php if (!$page->hidetitle) : ?>
            <h1><?= CHtml::link($page->parent->title, $page->parent->url) ?></h1>
        <?php endif; ?>

        <div class="subpages">
            <ul>
                <?php foreach ($page->parent->child_pages as $child) : ?>
                    <?php $url = $child->url; ?>
                    <?php if (Yii::app()->request->requestUri === $url) : ?>
                        <li class="active"><a href="<?= $url ?>"><?= $child->title ?></a></li>
                    <?php else : ?>
                        <li><a href="<?= $url ?>"><?= $child->title ?></a></li>
                    <?php endif; ?>
                <?php endforeach; ?>
            </ul>
            <div class="clear"></div>
        </div>

    <?php elseif ($page->child_pages) : ?>
        <?php if (!$page->hidetitle) : ?>
            <h1><?= $page->title ?></h1>
        <?php endif; ?>

        <div class="subpages">
            <ul>
                <?php foreach ($page->child_pages as $child) : ?>
                    <li><a href="<?= $child->url ?>"><?= $child->title ?></a></li>
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
