<table class="grid">
    <tr>
        <th style="width:50px"></th>
        <th>Артикул</th>
        <th>Наименование</th>
        <th>Характеристики</th>
        <th style="width:100px">Цена</th>
        <th style="width:100px">Количество</th>
        <th style="width:30px"></th>
        <th style="width:30px"></th>
    </tr>
    <?php foreach ($model->related_products as $product): ?>

        <?php $updateUrl = $this->createUrl('update', array('id'=>$product->id)); ?>
        <?php $deleteUrl = $this->createUrl('delete', array('id'=>$product->id)); ?>

        <?php if ($product->id == $model->id): ?>
            <tr id="product_<?php echo $product->id; ?>" class="active">
        <?php else: ?>
            <tr id="product_<?php echo $product->id; ?>">
        <?php endif; ?>
        <td><?php echo  CHtml::link(CHtml::image($product->firstImage->getThumbUrl(250, 250), '', array('width'=>'50px', 'height'=>'50px')), $updateUrl) ; ?></td>
        <td class="center"><?php echo CHtml::link(CHtml::encode($product->artikul), $updateUrl); ?></td>
        <td class="center"><?php echo CHtml::encode($product->title); ?></td>
        <td>
                <table class="nomargin">
                <?php foreach($product->otherAttributes as $attribute): ?>
                    <tr>
                        <td style="width:50%"><?php echo $attribute->title; ?></td>
                        <td><?php echo $attribute->value; ?></td>
                    </tr>
                    <?php endforeach; ?>
                </table>
        </td>
        <td class="center"><?php echo number_format($product->price, 0, '.', ' '); ?></td>
        <td class="center"><?php echo $product->count; ?></td>
        <td class="center"><?php echo CHtml::link(CHtml::image(Yii::app()->request->baseUrl . '/core/images/admin/edit.png'), $updateUrl); ?></td>
        <td class="center"><?php echo CHtml::link(CHtml::image(Yii::app()->request->baseUrl . '/core/images/admin/del.png'), $deleteUrl, array('class'=>'ajax_del', 'data-del'=>'product_' . $product->id, 'title'=>'Удалить')); ?></td>
        </tr>
    <?php endforeach; ?>
</table>

<br />