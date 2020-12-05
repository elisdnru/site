<?php
use app\modules\page\models\Page;
use yii\caching\TagDependency;
use yii\web\View;

/**
 * @var View $this
 * @var Page $page
 */
?>
<?php if ($this->beginCache(__FILE__ . __LINE__ . '_tabschild_' . $page->id, ['dependency' => new TagDependency(['tags' => 'page'])])) : ?>
    <?php if ($page->children) : ?>
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

    <?php $this->endCache(); ?>
<?php endif; ?>
<!-- /Подстраницы (дочерние табы) -->
