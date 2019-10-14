<?php
/** @var $data \app\modules\comment\models\Comment */
use app\components\helpers\SocNetworkHelper;
use app\components\helpers\TextHelper;

$groupurl = $this->createUrl('index', ['id' => $data->material_id]);
$editurl = $this->createUrl('update', ['id' => $data->id]);
$delurl = $this->createUrl('delete', ['id' => $data->id]);
$publicurl = $this->createUrl('toggle', ['attribute' => 'public', 'id' => $data->id]);
$moderurl = $this->createUrl('toggle', ['attribute' => 'moder', 'id' => $data->id]);
?>

<article class="comment<?php if (!$data->moder) :
    ?> newcomment<?php
endif; ?><?php if (!$data->public) :
    ?> nopublcomment<?php
endif; ?>" id="comment_<?php echo $data->id; ?>">

    <?php if ($data->cache(1000)->user) : ?>
        <img class="userpic" src="<?php echo $data->getAvatarUrl(50, 50); ?>" />
    <?php else : ?>
        <img class="userpic" src="<?php echo $data->getAvatarUrl(50, 50); ?>" />
    <?php endif; ?>

    <header>

        <span class="link">
            <a class="ajax_del" data-del="item_<?php echo $data->id; ?>" title="Прочитать/Вернуть комментарий" href="<?php echo $moderurl ?>"><img src="/images/admin/yes.png" width="16" height="16" alt="<?php echo $data->public ? 'Прочесть' : 'Новый'; ?>" title="<?php echo $data->public ? 'Прочесть' : 'Новый'; ?>" /></a>
            <a class="ajax_del" data-del="item_<?php echo $data->id; ?>" title="Скрыть/отобразить комментарий" href="<?php echo $publicurl; ?>"><img src="/images/admin/no.png" width="16" height="16" alt="<?php echo $data->public ? 'Скрыть' : 'Опубликовать'; ?>" title="<?php echo $data->public ? 'Скрыть' : 'Опубликовать'; ?>" /></a>
            <a href="<?php echo $editurl; ?>"><img src="/images/admin/edit.png" width="16" height="16" alt="Редактировать" title="Редактировать" /></a>
            <a class="ajax_del" data-del="comment_<?php echo $data->id; ?>" title="Удалить комментарий" href="<?php echo $delurl; ?>"><img src="/images/admin/del.png" width="16" height="16" alt="Удалить" title="Удалить" /></a>
        </span>

        <span class="like">
            <span id="like_<?php echo $data->id; ?>"><?php echo $data->likes; ?></span>
            <a rel="nofollow" class="ajax_load like_icon<?php if ($data->liked) :
                ?> like_active<?php
            endif; ?>" data-load="like_<?php echo $data->id; ?>" href="<?php echo Yii::app()->createUrl('comment/ajax/like', ['id' => $data->id]); ?>" title="Мне нравится"></a>
        </span>

        <h2 class="date"><?php echo $data->date; ?></h2>

        <?php if ($data->user && $data->user->network) : ?>
            <a target="_blank" rel="nofollow" href="<?php echo $data->user->identity; ?>"><?php echo SocNetworkHelper::getIcon($data->user->network); ?></a>
        <?php endif; ?>

        <span class="author">
            <?php if ($data->site) : ?>
                <cite><a rel="nofollow" href="<?php echo CHtml::encode($data->site); ?>"><?php echo CHtml::encode($data->name); ?></a></cite>
            <?php elseif ($data->name) : ?>
                <?php echo CHtml::encode($data->name); ?>
            <?php else : ?>
                <i>Неизвестный</i>
            <?php endif; ?>
        </span>

    </header>

    <div class="text">
        <?php echo TextHelper::fixBR($data->text_purified); ?>
        <p>
            <?php if ($data->material) : ?>
                <a href="<?php echo $data->url; ?>"><?php echo CHtml::encode($data->material->title); ?></a><?php
            endif; ?>
            <!-- | <a href="<?php echo $groupurl; ?>">Комментарии</a> -->
        </p>
    </div>

    <div class="clear"></div>

</article>
