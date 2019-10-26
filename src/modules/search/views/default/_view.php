<?php
/** @var $this \yii\web\View */

use app\components\Controller;
use app\modules\search\components\SearchHighlighter;
use app\modules\search\models\Search;
use yii\db\ActiveRecord;

/** @var $data Search */
/** @var $query ActiveRecord */
?>

<article class="entry list">
    <header>
        <h2>
            <a href="<?= $data->material->url ?>"><?= SearchHighlighter::getFragment(strip_tags($data->title), $query) ?></a>
        </h2>
        <?php if ($data->material->hasAttribute('image')) : ?>
            <?php
            $properties = [];
            if (!empty($data->material->image_width)) {
                $properties['width'] = $data->material->image_width;
            }
            if (!empty($data->material->image_height)) {
                $properties['height'] = $data->material->image_height;
            }
            ?>
            <p class="thumb">
                <a href="<?= $data->material->url ?>"><?= CHtml::image($data->material->getImageThumbUrl(), '', $properties) ?></a>
            </p>
        <?php endif; ?>
    </header>
    <div class="short"><?= SearchHighlighter::getFragment(strip_tags($this->clearWidgets($data->text)), $query) ?>
        ...
    </div>
    <div class="clear"></div>
</article>
