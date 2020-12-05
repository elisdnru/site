<?php

use app\modules\portfolio\widgets\PortfolioWidget;
use app\modules\user\models\Access;
use yii\web\View;

/**
 * @var View $this
 * @var array $series
 * @var array $items
 */

$this->context->layout = 'index';

$this->title = 'Услуги по интернет-разработке';

$this->registerMetaTag([
    'name' => 'description',
    'content' => 'Услуги по интернет-разработке',
]);

$this->params['breadcrumbs'] = [
    'Услуги',
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
    <h1>Услуги по интернет-разработке</h1>

    <div class="text">
        <?= PortfolioWidget::widget(['limit' => 7]) ?>

        <div style="width: 400px; float: right; margin-top: -20px;">
            <p style="text-align: right; margin-bottom: 20px;"><img src="/images/services.jpg" width="400" height="300" alt="" /></p>
        </div>
        <div>
            <h2>Актуальность разработки интернет-проектов</h2>
            <p>С каждым днём интернет-технологии проникают во всё больше сфер жизнедеятельности. Но не все осознают возможности, которые это даёт каждому из нас. В интернете не только создаются информационные страницы для публикации полезной информации и торговые площадки, но и разрабатывается всё больше сетевых аналогов офисных и домашних приложений: органайзеров, редакторов документов, хранилищ закладок, генераторов бухгалтерской отчетности и многих других.</p>
            <h2>Представительство и автоматизация</h2>
            <p>Сайты и подобные сервисы &ndash; отличные инструменты, позволяющие легко сообщить о себе большому кругу людей, упростить и автоматизировать повседневные действия, обмениваться документами, держать необходимые данные всегда под рукой, оставаться на связи со знакомыми, создать новый или усовершенствовать существующий бизнес.</p>
        </div>
        <p class="clear">&nbsp;</p>
        <div class="smart">
            <div class="item item_web">
                <div class="body">
                    <div class="title">
                        <p>Веб-дизайн</p>
                    </div>
                    <ul>
                        <li>Индивидуальный дизайн</li>
                        <li>Рекламные баннеры</li>
                        <li>Соблюдение правил юзабилити</li>
                        <li>Редизайн существующих сайтов</li>
                    </ul>
                </div>
            </div>
            <div class="item item_verstka">
                <div class="body">
                    <div class="title">
                        <p>HTML-вёрстка</p>
                    </div>
                    <ul>
                        <li>Блочная, табличная, смешанная</li>
                        <li>Кроссбраузерная, валидная</li>
                        <li>Соответствие стандартам W3C</li>
                        <li>Встраивание слайдеров, галерей</li>
                    </ul>
                </div>
            </div>
            <div class="item item_program">
                <div class="body">
                    <div class="title">
                        <p>Веб-программирование</p>
                    </div>
                    <ul>
                        <li>Разработка CMS и прочих систем</li>
                        <li>Использование фреймворков</li>
                        <li>Работа с JQuery, встраивание Ajax</li>
                        <li>Привязка платёжных систем</li>
                    </ul>
                </div>
            </div>
            <div class="item item_site">
                <div class="body">
                    <div class="title">
                        <p>Сайт &laquo;под ключ&raquo; &raquo;</p>
                    </div>
                    <ul>
                        <li>Сайт-визитка</li>
                        <li>Сайт-портфолио</li>
                        <li>Интернет-магазины</li>
                        <li>Интернет-порталы</li>
                    </ul>
                </div>
            </div>
        </div>
        <h2>Разработка под персональные требования</h2>
        <p>В последнее время создано много готовых конструкторов (как бесплатных, так и коммерческих), позволяющих за один день сделать стандартный сайт на готовом шаблоне (бесплатном или за небольшие деньги). Но нестандартный сайт под персональные требования и с оригинальным дизайном с их помощью сделать нельзя. Сайт-визитку сделать можно, а калькулятор стоимости ипотеки &ndash; нет.</p>
    </div>
</section>
