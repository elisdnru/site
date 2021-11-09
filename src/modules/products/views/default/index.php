<?php declare(strict_types=1);

use app\modules\user\models\Access;
use yii\helpers\Url;
use yii\web\View;

/**
 * @var View $this
 * @var array $series
 * @var array $items
 */
$this->context->layout = 'index';

$this->title = 'Авторские продукты';

$this->registerMetaTag([
    'name' => 'description',
    'content' => 'Мастер-классы и интенсивы Дмитрия Елисеева по программированию',
]);

$this->params['breadcrumbs'] = [
    'Авторские продукты',
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
    <h1>Авторские продукты</h1>

    <div class="text">
        <hr />

        <h2>Ресурсы:</h2>

        <ul class="products-cards">
            <li>
                <a href="/blog">Блог по разработке elisdn.ru</a><br />
                Блог со всеми статьями, докладами, вебинарами, интервью и анонсами.
            </li>
            <li>
                <a href="https://deworker.pro/edu" target="_blank">База знаний deworker.pro</a><br />
                Новый проект со скринкастами о программировании, работающий  по подписке как Patreon, LaraCasts и SymfonyCasts.<br />
                Продвинутые примеры по архитектуре и инфраструктуре с использованием современных технологий.
            </li>
        </ul>

        <hr />

        <h2>Сейчас идут:</h2>

        <ul class="products-cards">
            <li class="new">
                <a href="https://deworker.pro/edu/series/interactive-site" target="_blank">Разработка интерактивного аукциона на Slim PHP и ReactJS</a><br />
                Разработка под ключ полноценного проекта по современным практикам DevOps, CI/CD и DDD.<br />Построение фронтенда на React и разработка API на микрофреймворке.
            </li>
            <li class="new">
                <a href="https://deworker.pro/edu/series/what-is-react" target="_blank">Исследование React на примере написания UI-фреймворка</a><br />
                Рассмотрение принципов работы и устройства React и его экосистемы через написание своего JavaScript-фреймворка для построения проектов с реактивным пользовательским интерфейса для фронтенда.
            </li>
        </ul>

        <p>&hellip;и остальные <a href="https://deworker.pro/edu/series" target="_blank">серии скринкастов</a>, доступные в базе знаний.</p>

        <hr />

        <h2>Мега-мастер-классы в записи:</h2>

        <ul class="products-cards">
            <li>
                <a href="/oop-week" target="_blank">Основополагающий интенсив &laquo;Неделя ООП&raquo;</a><br />
                Полноценный шестидневный интенсив по рассмотрению принципов и основополагающих паттернов ООП, необходимых для понимания работы ООП-фреймворков. Тридцать полноценных примеров кода из реальных проектов вместо малополезных примеров про собачек и кошечек.
            </li>
            <li class="free">
                <a href="/blog/113/psr7-framework-http" target="_blank">Бесплатный мастер-класс по разработке PSR-микрофреймворка</a><br />
                Изучение работы фреймворков через исследование внутреннего устройства каждого компонента. Построение Pipeline для использования middleware. Контейнеры внедрения зависимостей. Написание фреймворконезависимого кода. Использование интерфейсов PSR.
            </li>
            <li>
                <a href="/git-composer" target="_blank">Практикум по Git и Composer</a><br />
                Запись практикума по разработке с системой контроля версий Git. Создание и исправление коммитов.<br />
                Работа с ветками и осуществление командной работы.
            </li>
            <li>
                <a href="/yii2-shop" target="_blank">Мастер-класс по разработке интернет-магазина на Yii2</a><br />
                Одиннадцатидневный мастер-класс по разработке полноценного интернет-магазина на скелетоне yii2-app-advanced. Выделение сервисного слоя и продвинутая работа с ActiveRecord. Активное использование DI-контейнера. Вложенные категории с Nested Sets. Подключение ElasticSearch и синхронизация по доменным событиям.
            </li>
            <li>
                <a href="/laravel-board" target="_blank">Мастер-класс по разработке сайта объявлений на Laravel</a><br />
                Тринадцатидневный мастер-класс по разработке продвинутой доски объявлений на фреймворке Laravel. Выделение сервисного слоя. Вложенные категории и регионы. Модерация объявлений. Геолокация. Привязка Яндекс.Карт. Избранное. Сложный поиск через ElasticSearch.
            </li>
            <li>
                <a href="/blog/125/rabbitmq-master-class" target="_blank">Мастер-класс по Apache Kafka и RabbitMQ</a><br />
                Трёхдневный мастер-класс по разработке демо-проекта видеохостинга. Написание функциональности конвертации видео в нужные форматы. Построение абстрактной модели видеоконвертера. Использование очередей RabbitMQ или Apache Kafka для конвертации видеофайлов в фоновом процессе.
            </li>
            <li class="top">
                <a href="/project-manager" target="_blank">Мастер-класс по разработке менеджера проектов на Symfony</a><br />
                Пятнадцатидневный мастер-класс по разработке продвинутого проекта таск-менеджера на Symfony. Использование Docker. Проектирование богатой доменной модели. Продвинутое управление доступом участников к своим проектам. Модульные и функциональные тесты. Слабосвязанный модульный подход. Использование Centrifugo для WebSocket-уведомлений. Разработка API с OAuth2 аутентификацией и Swagger-документацией.
            </li>
        </ul>

        <hr />

        <h2>Книги:</h2>

        <ul class="products-cards">
            <li>
                <a href="/blog/102/yii2-application-development-cookbook" target="_blank">Yii2 Application Development Cookbook</a><br />
                Новое издание классической книги рецептов по разработке на фреймворке Yii, переписанное для Yii2.
            </li>
        </ul>

        <hr />

        <p style="margin-bottom: 0"><a href="<?= Url::to(['/partner/default/index']); ?>">Партнёрская программа</a></p>
    </div>
</section>
