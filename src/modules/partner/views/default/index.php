<?php declare(strict_types=1);

use app\modules\partner\model\Item;
use app\modules\user\models\Access;
use Webmozart\Assert\Assert;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\Application;
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

if (Assert::isInstanceOf(Yii::$app, Application::class)->user->can(Access::CONTROL)) {
    if (\app\notNull(Yii::$app)->moduleAdminAccess->isGranted('page')) {
        $this->params['admin'][] = ['label' => 'Страницы', 'url' => ['/page/admin/page/index']];
    }
    if (\app\notNull(Yii::$app)->moduleAdminAccess->isGranted('blog')) {
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
            Скрипт отслеживания партнёрских переходов размещён на всех страницах сайта и платёжных формах.
            Вы можете ссылаться на любую страницу или статью с добавлением к адресу utm-меток
            <code>?utm_medium=affiliate&utm_source=логин</code>
            с указанием вашего логина в партнёрской системе.
        </p>

        <p>
            После перехода по ссылке с вашими метками в браузере посетителя проставится cookie с вашим идентификатором.
        </p>

        <p>Когда посетитель приобретёт любой продукт вам зачислится вознаграждение с полной суммы заказа:</p>

        <table style="margin-bottom: 20px">
            <thead>
                <tr>
                    <th rowspan="2">Продукт</th>
                    <th rowspan="2">Цена</th>
                    <th colspan="2">Вознаграждение</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($items as $item): ?>
                    <tr>
                        <td>
                            <a href="<?= Html::encode($item->url); ?>"><?= Html::encode($item->title); ?></a>
                        </td>
                        <td style="text-align: right"><?= $item->price; ?> руб</td>
                        <td style="text-align: center"><?= $item->firstPercent; ?>%</td>
                        <td style="text-align: right"><?= $item->firstRoubles(); ?> руб</td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <p>
            Скрипт отслеживания размещён на всех страницах сайта, поэтому помимо перечисленных страниц вы можете
            ссылаться своими партнёрскими ссылками и на отдельные посты
            в <a href="<?= Url::to(['/blog/default/index']); ?>">блоге</a> с приглашением или подведением итогов.
            Также удобно ссылаться на официальную <a href="<?= Url::to(['/products/default/index']); ?>">страницу продуктов</a>.
        </p>

        <p>
            Обратите внимание, что партнёрская программа распространяется только на перечисленные в таблице продукты,
            продаваемые непосредственно на сайте elisdn.ru.
            Любые другие продукты, размещённые и продаваемые на сторонних сайтах вроде deworker.pro,
            в этой партнёрской программе не участвуют.
        </p>

        <p>
            Партнёрское вознаграждение выплачивается на банковскую карту по СБП. Оплата производится в первых числах следующего месяца,
            но вы можете попросить произвести выплату раньше, написав мне в
            <a href="<?= Url::to(['/contacts/default/index']); ?>">обратную связь</a>.
        </p>

        <p>
            При участии в программе не допускаются махинации и СПАМ. Если вы сами приобретёте продукт по своей собственной
            партнёрской ссылке, то вознаграждение аннулируется и выплачено не будет.
        </p>

        <p style="text-align: center; margin: 30px 0 15px 0">
            <a target="_blank" class="order-button" href="https://products.elisdn.ru/join" rel="noopener">Стать партнёром</a>
        </p>
    </div>
</section>
