<?php

use app\modules\partner\model\Item;
use app\modules\user\models\Access;
use yii\helpers\Html;
use yii\helpers\Url;
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
        <p>
            Если вам нравятся мои продукты и вы хотите их рекламировать за партнёрское вознаграждение,
            то присоединяйтесь к партнёрской программе.
        </p>

        <p>
            Вся работа по учёту партнёров и вознаграждений осуществляется сервисом
            <a href="https://justclick.ru">JustCLick</a>, через который производится подписка
            на рассылку и продажа продуктов, размещённых непосредственно на этом сайте elisdn.ru
        </p>

        <p>
            Скрипт отслеживания партнёрских переходов размещён на всех страницах сайта и платёжных формах.
            Вы можете ссылаться на любую страницу или статью с добавлением к адресу utm-меток
            <code>?utm_medium=affiliate&utm_source=логин</code>
            с указанием вашего логина в системе JustClick.
        </p>

        <p>
            После перехода по ссылке с вашими метками в браузере посетителя проставится cookie с вашим идентификатором.
        </p>

        <p>
            Приведённый вами посетитель вдальнейшем может либо приобрести любой продукт, либо подписаться на рассылку
            через форму в сайдбаре, через формы в некоторых постах в блоге или через
            <a href="<?= Url::to(['/subscribe/default/index']) ?>">страницу подписки</a>.
            В любом случае после подписки или покупки посетитель станет закреплён за вами по email
            и вам будет начисляться вознаграждение за все его покупки с этого email.
        </p>

        <p>Продукты, участвующие в партнёрской программе:</p>

        <table style="margin-bottom: 20px">
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

        <p>
            Скрипт отслеживания размещён на всех страницах сайта, поэтому помимо перечисленных страниц вы можете
            ссылаться своими партнёрскими ссылками и на отдельные посты
            в <a href="<?= Url::to(['/blog/default/index']) ?>">блоге</a> с приглашением или подведением итогов.
        </p>

        <p>
            Также удобно ссылаться на официальную <a href="<?= Url::to(['/products/default/index']) ?>">страницу продуктов</a>.
        </p>

        <p>
            Обратите внимание, что партнёрская программа распространяется только на перечисленные в таблице продукты,
            размещённые непосредственно на сайте elisdn.ru и продаваемые здесь через систему JustClick.
            Любые другие продукты, размещённые и продаваемые на сторонних сайтах вроде deworker.pro,
            в этой партнёрской программе не участвуют.
        </p>

        <p>
            Партнёрское вознаграждение выплачивается через ЮMoney (Яндекс.Деньги)
            или переводом на банковскую карту (возможна комиссия). Оплата производится в первых числах следующего месяца,
            но вы можете попросить произвести выплату раньше, написав мне в
            <a href="<?= Url::to(['/contacts/default/index']) ?>">обратную связь</a>.
        </p>

        <p>
            При участии в программе не допускаются махинации и СПАМ. Если вы сами приобретёте продукт по своей собственной
            партнёрской ссылке, то вознаграждение аннулируется и выплачено не будет. Поэтому после тестирования
            своих ссылок удалите свой идентификатор из cookies вашего браузера.
        </p>

        <p style="text-align: center; margin: 30px 0 15px 0">
            <a target="_blank" class="order-button" href="https://products.elisdn.ru/join/" rel="noopener">Подключиться к программе</a>
        </p>
    </div>
</section>
