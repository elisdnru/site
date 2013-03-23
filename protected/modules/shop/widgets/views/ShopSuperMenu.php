<div class="superMenu">

<?php $this->widget('DIconMenu',array(
    'items'=>ShopType::model()->cache(3600*24)->getSuperMenuList())
); ?>

    <ul>
        <li class="brands"><img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/brands-icon.png" /><span>Бренды</span>
            <?php $this->widget('DIconMenu',array(
                    'items'=>ShopBrand::model()->cache(3600*24)->getMenuList())
            ); ?>
        </li>
    </ul>
    <div class="clear"></div>
</div>