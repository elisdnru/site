<?php
use app\modules\page\models\Page;
use yii\helpers\Html;
use yii\web\View;

/** @var $this View */
/** @var $models Page[] */
/** @var $parent Page */
?>
<ul>
    <?php foreach ($models as $model) : ?>
        <?php if ($model->parent_id == $parent) : ?>
            <li><a href="<?= $model->getUrl() ?>"><?= Html::encode($model->title) ?></a>
                <?= $this->render('_recursive', ['models' => $models, 'parent' => $model->id]) ?>
            </li>
        <?php endif; ?>
    <?php endforeach; ?>
</ul>
