<div class="subpages_list <?php echo $class; ?>">
    <ul>
        <?php foreach ($pages as $page) : ?>
            <li><a href="<?php echo $page->url; ?>">
                    <?php if ($images && $page->image) :
                        ?><?php echo CHtml::image($page->imageThumbUrl, $page->image_alt); ?><?php
                    endif; ?><?php echo $page->title; ?>
                </a></li>
        <?php endforeach; ?>
    </ul>
</div>
