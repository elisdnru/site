<?php
/* @var $this Controller */

use app\components\Controller;
use app\modules\page\models\Page;

/* @var $models Page[] */
?>
<ul>
    <?php foreach ($models as $model) : ?>
        <?php if ($model->parent_id == $parent && $model->url !== '/prices') : ?>
            <li><a href="<?php echo $model->url; ?>"><?php echo CHtml::encode($model->title); ?></a>
                <?php $this->renderPartial('_recursive', ['models' => $models, 'parent' => $model->id]); ?>
            </li>
        <?php endif; ?>
    <?php endforeach; ?>
</ul>
