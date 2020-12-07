<?php
use app\modules\user\models\Access;
use app\modules\user\models\User;
use yii\data\ActiveDataProvider;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;
use yii\widgets\LinkPager;

/**
 * @var View $this
 * @var User $model
 * @var ActiveDataProvider $dataProvider
 */

$this->title = 'Пользователи';
$this->params['breadcrumbs'] = [
    'Пользователи',
];

$this->params['admin'][] = ['label' => 'Панель управления', 'url' => ['/']];
?>

<h1>Пользователи</h1>

<div id="posts-grid" class="grid-view">
    <div class="summary"><?= $dataProvider->getCount() ?> из <?= $dataProvider->getTotalCount() ?></div>
    <form action="?" method="get">
        <table class="items">
            <thead>
                <tr>
                    <th></th>
                    <th><?= $dataProvider->getSort()->link('username', ['class' => 'sort-link', 'label' => 'Логин']) ?></th>
                    <th><?= $dataProvider->getSort()->link('email', ['class' => 'sort-link', 'label' => 'Email']) ?></th>
                    <th><?= $dataProvider->getSort()->link('fio', ['class' => 'sort-link', 'label' => 'ФИО']) ?></th>
                    <th><?= $dataProvider->getSort()->link('role', ['class' => 'sort-link', 'label' => 'Роль']) ?></th>
                    <th></th>
                    <th><?= $dataProvider->getSort()->link('create_datetime', ['class' => 'sort-link', 'label' => 'Дата']) ?></th>
                    <th></th>
                    <th></th>
                    <th></th>
                </tr>
                <tr class="filters">
                    <td></td>
                    <td><?= Html::activeTextInput($model, 'username') ?></td>
                    <td><?= Html::activeTextInput($model, 'email') ?></td>
                    <td><?= Html::activeTextInput($model, 'fio') ?></td>
                    <td><?= Html::activeDropDownList($model, 'role', Access::getRoles(), ['prompt' => '']) ?></td>
                    <td></td>
                    <td><?= Html::activeTextInput($model, 'create_datetime') ?></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($dataProvider->getModels() as $user) : ?>
                    <?php /** @var $user User */ ?>
                    <tr>
                        <td style="width:50px">
                            <img src="<?= $user->getAvatarUrl(50, 50) ?>" width="50px" alt=""/>
                        </td>
                        <td style="text-align: center">
                            <a href="<?= Url::to(['view', 'id' => $user->id]) ?>"><?= Html::encode($user->username) ?></a>
                        </td>
                        <td>
                            <?= Html::encode($user->email) ?>
                        </td>
                        <td>
                            <a href="<?= Url::to(['update', 'id' => $user->id]) ?>"><?= Html::encode($user->getFio()) ?></a>
                        </td>
                        <td style="text-align: center">
                            <?= Html::encode(Access::getRoleName($user->role)) ?>
                        </td>
                        <td>
                            <?php if (!$user->confirm) : ?>
                                <img title="Активен" style="width:16px; height:16px;" src="/images/admin/yes.png" alt="">
                            <?php else : ?>
                                <img title="Ожидает" style="width:16px; height:16px;" src="/images/admin/message.png" alt="">
                            <?php endif; ?>
                        </td>
                        <td>
                            <?= Html::encode($user->create_datetime) ?>
                        </td>
                        <td class="button-column"><a href="<?= Url::to(['view', 'id' => $user->id]) ?>"><span class="icon view"></span></a></td>
                        <td class="button-column"><a href="<?= Url::to(['update', 'id' => $user->id]) ?>"><span class="icon edit"></span></a></td>
                        <td class="button-column"><a href="<?= Url::to(['delete', 'id' => $user->id]) ?>" class="ajax_del"><span class="icon delete"></span></a></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <button type="submit" style="visibility: hidden"></button>
    </form>
</div>

<?= LinkPager::widget(['pagination' => $dataProvider->getPagination()]) ?>
