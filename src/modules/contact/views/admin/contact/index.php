<?php
/** @var $this \yii\web\View */

use app\modules\contact\models\Contact;
use app\components\AdminController;
use yii\data\ActiveDataProvider;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\LinkPager;

/** @var $model Contact */
/** @var $dataProvider ActiveDataProvider */

$this->title = 'Сообщения';
$this->params['breadcrumbs'] = [
    'Панель управления' => ['/admin'],
    'Сообщения',
];

if (Yii::$app->moduleManager->allowed('comment')) {
    $this->params['admin'][] = ['label' => 'Комментарии', 'url' => ['/comment/admin/comment/index']];
}
?>

<h1>Сообщения</h1>

<div class="grid-view">
    <div class="summary"><?= $dataProvider->getCount() ?> из <?= $dataProvider->getTotalCount() ?></div>
    <form action="?" method="get">
        <table class="items">
            <thead>
                <tr>
                    <th><?= $dataProvider->getSort()->link('date', ['class' => 'sort-link', 'label' => 'Дата']) ?></th>
                    <th><?= $dataProvider->getSort()->link('name', ['class' => 'sort-link', 'label' => 'Имя']) ?></th>
                    <th><?= $dataProvider->getSort()->link('email', ['class' => 'sort-link', 'label' => 'Email']) ?></th>
                    <th><?= $dataProvider->getSort()->link('text', ['class' => 'sort-link', 'label' => 'Текст']) ?></th>
                    <th><?= $dataProvider->getSort()->link('pagetitle', ['class' => 'sort-link', 'label' => 'Страница']) ?></th>
                    <th><?= $dataProvider->getSort()->link('status', ['class' => 'sort-link', 'label' => 'П']) ?></th>
                    <th></th>
                    <th></th>
                </tr>
                <tr class="filters">
                    <td><?= Html::activeTextInput($model, 'date') ?></td>
                    <td><?= Html::activeTextInput($model, 'name') ?></td>
                    <td><?= Html::activeTextInput($model, 'email') ?></td>
                    <td><?= Html::activeTextInput($model, 'text') ?></td>
                    <td><?= Html::activeTextInput($model, 'pagetitle') ?></td>
                    <td><?= Html::activeDropDownList($model, 'status', [1 => 'Прочитано', 0 => 'Новое'], ['prompt' => '']) ?></td>
                    <td></td>
                    <td></td>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($dataProvider->getModels() as $contact): ?>
                <?php /** @var Contact $contact */ ?>
                    <tr>
                        <td style="width:130px; text-align:center"><?= $contact->date ?></td>
                        <td style="text-align:center"><?= Html::encode($contact->name) ?></td>
                        <td style="text-align:center"><?= Html::encode($contact->email) ?></td>
                        <td><?= CHtml::link(CHtml::encode(mb_substr($contact->text, 0, 59, 'UTF-8')), Url::to(['view', 'id' => $contact->id])) ?></td>
                        <td><?= Html::encode($contact->pagetitle) ?></td>
                        <td style="width:30px;text-align:center">
                            <a class="ajax_post" href="<?= Url::to(['toggle', 'id' => $contact->id, 'attribute' => 'status']) ?>">
                                <?php if ($contact->status): ?>
                                    <img title="Прочитано" style="width:16px; height:16px;" class="icon-on" src="/images/admin/yes.png" alt="Прочитано">
                                <?php else: ?>
                                    <img title="Новое" style="width:16px; height:16px;" class="icon-on" src="/images/admin/message.png" alt="Новое">
                                <?php endif; ?>
                            </a>
                        </td>
                        <td class="button-column"><a href="<?= Url::to(['view', 'id' => $contact->id]) ?>"><span class="icon view"></span></a></td>
                        <td class="button-column"><a href="<?= Url::to(['delete', 'id' => $contact->id]) ?>" class="ajax_del"><span class="icon delete"></span></a></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <button type="submit" style="visibility: hidden"></button>
    </form>
</div>

<?= LinkPager::widget(['pagination' => $dataProvider->getPagination()]) ?>
