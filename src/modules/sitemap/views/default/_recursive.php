<?php
/** @var $this \yii\web\View */

use app\components\Controller;
use app\modules\page\models\Page;

/** @var $models Page[] */
/** @var $parent Page */
?>
<ul>
    <?php foreach ($models as $model) : ?>
        <?php if ($model->parent_id == $parent && $model->url !== '/prices') : ?>
            <li><a href="<?= $model->url ?>"><?= CHtml::encode($model->title) ?></a>
                <?= $this->render('_recursive', ['models' => $models, 'parent' => $model->id]); ?>
            </li>
        <?php endif; ?>
    <?php endforeach; ?>
</ul>
