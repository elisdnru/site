<?php declare(strict_types=1);

use app\components\module\sitemap\Item;
use yii\helpers\Html;
use yii\web\View;

/**
 * @var View $this
 * @var Item[] $items
 */
?>

<?php if ($items): ?>
    <ul>
        <?php foreach ($items as $item): ?>
            <?php if ($item->label || $item->children): ?>
                <li>
                    <?php if ($item->label): ?>
                        <a href="<?= $item->url; ?>"><?= Html::encode($item->label); ?></a>
                    <?php endif; ?>
                    <?= $this->render('_recursive', ['items' => $item->children, 'models' => [], 'parent' => 0]); ?>
                </li>
            <?php endif; ?>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>

