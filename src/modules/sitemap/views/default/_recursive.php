<?php
/* @var $this DController */
/* @var $models Page[] */
?>
<ul>
    <?php foreach ($models as $model) : ?>
        <?php if ($model->parent_id == $parent && $model->url != '/prices') : ?>
            <li><span data-href="<?php echo $model->url; ?>"><?php echo CHtml::encode($model->title); ?></span>
                <?php $this->renderPartial('_recursive', ['models' => $models, 'parent' => $model->id]); ?>
            </li>
        <?php endif; ?>
    <?php endforeach; ?>
</ul>