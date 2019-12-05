<?php
/** @var $data \app\modules\comment\models\Comment */

use app\components\purifier\CommentPostFilter;
use app\components\SocNetwork;
use yii\helpers\Html;
use yii\helpers\Url;

$groupurl = Url::to(['index', 'id' => $data->material_id]);
$editurl = Url::to(['update', 'id' => $data->id]);
$delurl = Url::to(['delete', 'id' => $data->id]);
$publicurl = Url::to(['toggle', 'attribute' => 'public', 'id' => $data->id]);
$moderurl = Url::to(['toggle', 'attribute' => 'moder', 'id' => $data->id]);
?>

<article class="comment<?= !$data->moder ? ' newcomment' : '' ?><?= !$data->public ? ' nopublcomment' : '' ?>" id="comment_<?= $data->id ?>">
    <?php if ($data->user) : ?>
        <img class="userpic" src="<?= $data->getAvatarUrl(50, 50) ?>" alt="">
    <?php else : ?>
        <img class="userpic" src="<?= $data->getAvatarUrl(50, 50) ?>" alt="">
    <?php endif; ?>

    <header>

        <span class="link">
            <a class="ajax_del" data-del="item_<?= $data->id ?>" title="Прочитать/Вернуть комментарий" href="<?= $moderurl ?>"><img src="/images/admin/yes.png" width="16" height="16" alt="<?php echo $data->public ? 'Прочесть' : 'Новый' ?>" title="<?= $data->public ? 'Прочесть' : 'Новый' ?>"></a>
            <a class="ajax_del" data-del="item_<?= $data->id ?>" title="Скрыть/отобразить комментарий" href="<?= $publicurl ?>"><img src="/images/admin/no.png" width="16" height="16" alt="<?= $data->public ? 'Скрыть' : 'Опубликовать' ?>" title="<?= $data->public ? 'Скрыть' : 'Опубликовать' ?>"></a>
            <a href="<?= $editurl ?>"><img src="/images/admin/edit.png" width="16" height="16" alt="Редактировать" title="Редактировать"></a>
            <a class="ajax_del" data-del="comment_<?= $data->id ?>" title="Удалить комментарий" href="<?= $delurl ?>"><img src="/images/admin/del.png" width="16" height="16" alt="Удалить" title="Удалить"></a>
        </span>

        <span class="like">
            <span id="like_<?= $data->id ?>"><?= $data->likes ?></span>
            <a rel="nofollow" class="ajax_load like_icon<?= $data->liked ? ' like_active' : '' ?>" data-load="like_<?= $data->id ?>" href="<?= Url::to(['/comment/ajax/like', 'id' => $data->id]) ?>" title="Мне нравится"></a>
        </span>

        <h2 class="date"><?= $data->date ?></h2>

        <?php if ($data->user && $data->user->network) : ?>
            <a target="_blank" rel="nofollow" href="<?= $data->user->identity ?>"><?= SocNetwork::icon($data->user->network) ?></a>
        <?php endif; ?>

        <span class="author">
            <?php if ($data->site) : ?>
                <cite><a rel="nofollow" href="<?= Html::encode($data->site) ?>"><?= Html::encode($data->name) ?></a></cite>
            <?php elseif ($data->name) : ?>
                <?= Html::encode($data->name) ?>
            <?php else : ?>
                <i>Неизвестный</i>
            <?php endif; ?>
        </span>

    </header>

    <div class="text">
        <?= CommentPostFilter::fixMarkup($data->text_purified) ?>
        <p>
            <?php if ($data->material) : ?>
                <a href="<?= $data->url ?>"><?= Html::encode($data->material->title) ?></a><?php
            endif; ?>
            <!-- | <a href="<?= $groupurl ?>">Комментарии</a> -->
        </p>
    </div>

    <div class="clear"></div>

</article>
