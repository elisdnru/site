<?php

use app\modules\partner\model\Item;
use app\modules\user\models\Access;
use yii\helpers\Html;
use yii\web\View;

/**
 * @var View $this
 * @var array $series
 * @var Item[] $items
 */

$this->context->layout = 'index';

$this->title = 'Парнёрская программа';

$this->registerMetaTag([
    'name' => 'description',
    'content' => 'Парнёрская программа Дмитрия Елисеева',
]);

$this->params['breadcrumbs'] = [
    'Парнёрская программа',
];

if (Yii::$app->user->can(Access::CONTROL)) {
    if (Yii::$app->moduleAdminAccess->isGranted('page')) {
        $this->params['admin'][] = ['label' => 'Страницы', 'url' => ['/page/admin/page/index']];
    }
    if (Yii::$app->moduleAdminAccess->isGranted('blog')) {
        $this->params['admin'][] = ['label' => 'Записи', 'url' => ['/blog/admin/post/index']];
    }
}
?>

<section>
    <h1>Парнёрская программа</h1>

    <div class="text">
        <table>
            <thead>
                <tr>
                    <th rowspan="2">Продукт</th>
                    <th rowspan="2">Цена</th>
                    <th colspan="4">Комиссия</th>
                </tr>
                <tr>
                    <th colspan="2">1 уровень</th>
                    <th colspan="2">2 уровень</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($items as $item) : ?>
                    <tr>
                        <td>
                            <a href="<?= Html::encode($item->url) ?>"><?= Html::encode($item->title) ?></a>
                        </td>
                        <td style="text-align: right"><?= $item->price ?> руб</td>
                        <td style="text-align: center"><?= $item->firstPercent ?>%</td>
                        <td style="text-align: right"><?= $item->firstRoubles() ?> руб</td>
                        <td style="text-align: center"><?= $item->secondPercent ?>%</td>
                        <td style="text-align: right"><?= $item->secondRoubles() ?> руб</td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <p style="text-align: center; margin: 30px 0">
            <a target="_blank" class="order-button" href="https://products.elisdn.ru/join/" rel="noopener">Подключиться к программе</a>
        </p>
    </div>
</section>
