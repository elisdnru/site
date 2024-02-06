<?php declare(strict_types=1);

use app\widgets\NotificationBar;
use yii\helpers\Url;
use yii\web\View;

/**
 * @var View $this
 */
$this->title = 'Мастер-класс по разработке доски объявлений на Laravel Framework';
?>

<?php $this->beginBlock('meta'); ?>
<meta name="robots" content="index, nofollow">
<link href="https://fonts.googleapis.com/css?family=Roboto+Slab:400,300,700&amp;subset=latin,cyrillic-ext" rel="stylesheet">
<link href="https://fonts.googleapis.com/css?family=Roboto+Condensed:300italic,400italic,700italic,400,300,700&amp;subset=latin,cyrillic-ext,cyrillic" rel="stylesheet">
<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
<?php $this->endBlock(); ?>

<?php $this->beginBlock('styles'); ?>
    <style>
        body {
            background: #fff;
            color: #444;
        }

        header {
            height: 50px;
        }

        .navbar-nav {
            margin-left: -15px;
        }

        section {
            padding-top: 20px;
            padding-bottom: 20px;
            font-size: 15px;
            border-bottom: 1px solid #eee;
        }

        h1, h2, h3, h4 {
            font-family: 'Roboto Slab', serif;
            font-weight: bold;
            text-align: center;
            margin: 10px 0 30px 0;
        }

        h1 {
            margin-top: 5px;
            margin-bottom: 5px;
            font-size: 42px;
            color: #fff;
            line-height: 51px;
            text-shadow: 1px 1px 3px rgba(0, 0, 0, 0.3);
            font-weight: bold;
            text-align: center;
        }

        h2 {
            font-size: 32px;
        }

        h1 small {
            display: block;
            line-height: 36px;
        }
        .container {
            max-width: 960px;
        }

        .intro {
            position: relative;
            background: #00437c url('/landing/intro.jpg') no-repeat center top;
        }

        @media (width >=768px){
            .intro {
                min-height: 200px;
            }
        }

        .btn-danger {
            background: #E63C5A;
            border-color: #E63C5A;
        }
        .btn-danger:hover {
            background: #f33f5f;
            border-color: #f33f5f;
        }

        .bul-list {
            padding-left: 0;
            list-style-position: inside;
            margin-bottom: 30px;
        }

        .bul-list li {
            margin: 10px 0;
        }

        .format-block {
            border: 3px solid #eee;
            border-radius: 2px;
            margin: 20px 0 30px 0;
            padding: 0 20px 0 20px;
        }
        .format-block ul {
            margin: 0;
            padding: 0;
            list-style: none;
        }
        .format-block ul li {
            margin: 0;
            line-height: 1.2;
            padding: 20px 0;
            border-top: 1px solid #ddd;
        }
        .format-block ul li:first-child {
            border-top: none;
        }

        .price-item {
            border: 2px solid #eee;
            border-radius: 2px;
            margin: 20px 0 30px 0;
            padding: 20px 0 10px 0;
            text-align: center;
        }

        .price-item h3 {
            color: #333;
            height: 2em;
        }

        .price-item ul {
            text-align: left;
            font-size: 14px;
            margin: 18px 40px 0 40px;
            padding-left: 0;
            line-height: 17px;
            height: 8em;
            list-style: none;
        }

        .price-item ul li {
            margin: 10px 0;
        }

        .price-text {
            font: bold 24px 'Roboto Slab', serif;
            margin: 10px 0 0 0;
        }

        .price-text span {
            color: #E63C5A;
            font-size: 36px;
        }

        .price-button {
            cursor: pointer;
            background: #E63C5A;
            border-radius: 5px;
            display: inline-block;
            vertical-align: top;
            color: #FFF;
            padding: 11px 28px 14px;
            margin: 33px 0 29px 0;
            font: bold 24px 'Roboto Slab', serif;
        }

        .price-button a {
            color:#FFF;
            text-decoration:none;
        }

        .lesson {
            background: #eee;
            border: 2px solid #f3f3f3;
            border-radius: 2px;
            margin: 0 0 30px 0;
            padding: 20px 20px 10px 20px;
        }

        .block {
            background: #eee;
            border: 2px solid #f3f3f3;
            border-radius: 2px;
            margin: 0 0 30px 0;
            padding: 20px 20px 10px 20px;
        }
        .block ul {
            margin: 0;
            padding: 0;
            list-style: none;
        }
        .block ul li {
            margin: 0;
            line-height: 1.2;
            padding: 20px 0;
            border-top: 1px solid #ccc;
        }

        footer {
            padding: 20px 0 10px 0;
            text-align: center;
            font-size: 13px;
            color: #666;
        }

        footer p {
            margin-bottom: 10px;
        }

        footer a {
            color: #666;
            text-decoration: underline;
        }
    </style>
<?php $this->endBlock(); ?>

<header class="hidden-xs">
    <nav class="navbar navbar-default navbar-fixed-top" role="navigation" style="margin-bottom: 0">
        <div class="container">
            <ul class="navbar-nav nav">
                <li><a href="#for">Для кого</a></li>
                <li><a href="#author">Автор</a></li>
                <li><a href="#format">Формат</a></li>
                <li><a href="#program">Программа</a></li>
                <li><a href="#schedule">Расписание</a></li>
            </ul>
            <a href="#price" class="btn btn-danger navbar-btn pull-right">Приобрести записи</a>
        </div>
    </nav>
</header>

<section class="intro">
    <div class="container">
        <h1>Проект под ключ<small style="color: #fff">Практический мастер класс<br />по разработке проекта на фреймворке</small>&laquo;Сайт объявлений на Laravel&raquo;</h1>
    </div>
</section>

<section id="for">
    <div class="container">
        <div class="block">
            <p>Если хотите получить кучу эмоций и новых знаний, то приходите к нам на полноценный многодневный мастер-класс:<p>
            <div style="max-width: 886px; margin: 20px auto 10px auto;">
                <iframe width="100%" height="498" src="https://www.youtube.com/embed/gL-aRsPjK1k?rel=0&amp;showinfo=0" frameborder="0" allowfullscreen></iframe>
            </div>
            <p></p>
        </div>
        <h2>Присоединяйтесь, если Вы:</h2>
        <ul class="bul-list">
            <li>Занимаетесь разработкой на Laravel или планируете его изучить</li>
            <li>Разрабатываете на других фреймворках, но хотите перенять знания к себе в проект</li>
            <li>Испытываете сложности с документацией и хотите потренироваться на практике</li>
            <li>Хотите ознакомиться с различными архитектурными подходами</li>
            <li>Хотите перенять лучшие практики различных фреймворков</li>
            <li>Хотите потренироваться в применении знаний ООП или узнать, что это такое</li>
            <li>Хотите изучить модульное тестирование на реальных примерах</li>
            <li>Планируете заниматься разработкой REST API, его тестированием и документированием</li>
            <li>Хотите ознакомиться с NoSQL-технологиями</li>
            <li>Хотите использовать виртуальные машины для разработки</li>
            <li>Хотите узнать слабые и сильные места различных фреймворков</li>
        </ul>
        <p></p>
    </div>
</section>

<section id="author">
    <div class="container">
        <h2>Дмитрий Елисеев</h2>
        <div style="text-align: center">
            <p><img width="350" height="350" style="margin: 0" src="/landing/author.jpg" alt="Дмитрий Елисеев"/></p>
            <p>
                Программист с 2008 года.<br />
                Специализируется на теории и практике бэкенд-разработки.<br />
                Автор <a target="_blank" href="https://elisdn.ru">блога</a>,
                ведущий <a target="_blank" href="/blog/tag/%D0%92%D0%B5%D0%B1%D0%B8%D0%BD%D0%B0%D1%80">вебинаров</a>
                по веб-программированию,<br />
                автор интенсивов &laquo;<a target="_blank" href="/oop-week">Неделя ООП</a>&raquo; и &laquo;<a target="_blank" href="/yii2-shop">Магазин на Yii2</a>&raquo;.
            </p>
        </div>
    </div>
</section>

<section id="format">
    <div class="container">
        <h2>Формат участия</h2>
        <div class="format-block">
            <ul>
                <li>Вы получите доступ к личному кабинету ученика со всеми последующими инструкциями и необходимой информацией о каждом уроке.</li>
                <li>Уроки проводились в <b>онлайн-формате</b> в виде вебинаров-скринкастов с демонстрацией экрана и общением в чате.</li>
                <li>Записи и исходные коды проекта выложены в личный кабинет.</li>
                <li>Каждая тема занимает 1-3 урока. Суммарно получилось 13 уроков по 5-6 часов.</li>
            </ul>
        </div>
        <p style="text-align: center">По любым организационным и техническим вопросам Вам будет дан ответ в службе поддержки:</p>
    </div>
</section>

<section style="background: #f3f3f3">
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <div style="width: 270px; height: 270px; background: url('/landing/juli.jpg') center center no-repeat; border-radius: 1000px"></div>
            </div>
            <div class="col-md-8">
                <h3 style="text-align: left">Меня зовут Юлия</h3>

                <p>О моих пристрастиях к учёту и порядку ходят легенды, поэтому я решила направить их в полезное русло: до и во время интенсива я буду обеспечивать техническую поддержку всего процесса.</p>

                <p>Я буду решать все организационные моменты, следить за вашим комфортом, отвечать на ваши вопросы по электронной почте, проверять платежи и выставлять счета и акты юрлицам.</p>

                <p>Отвечать буду в порядке приоритетности: сначала на экстренные вопросы, потом на менее важное. Но всё равно ни одно письмо не пропадёт бесследно.</p>
            </div>
        </div>
    </div>
</section>

<section id="program">
    <div class="container">
        <h2>Программа мастер-класса</h2>

        <hr />

        <p>Чтобы проект был максимально полезным (по требованиям многих вакансий) изучим популярный стек технических вещей:</p>

        <ul class="bul-list">
            <li>Распределённое окружение на Docker</li>
            <li>Вложенные рубрики</li>
            <li>База городов и областей</li>
            <li>Динамические атрибуты для рубрик</li>
            <li>Сложный фильтр по атрибутам с ElasticSearch</li>
            <li>Баннерная система со статистикой</li>
            <li>Уведомления о событиях на сайте</li>
            <li>Очереди для фоновых задач</li>
            <li>Двухфакторная аутентификация с SMS</li>
            <li>Платное продвижение объявлений</li>
            <li>Геолокация для определения города</li>
            <li>Привязка Яндекс.Карт</li>
            <li>Интеграция систем почтовых рассылок</li>
            <li>JSON API для мобильных приложений</li>
        </ul>

        <p>...и другие полезные вещи.</p>
    </div>
</section>

<section id="schedule">
    <div class="container">
        <h2>Расписание</h2>
        <p style="text-align: center">Пункты могут меняться местами в ходе мастер-класса, но суть остаётся. Не отпущу вас, пока всё не расскажу :)</p>

        <div class="lesson">
            <h3>Тема 1: Философия, ТЗ, установка и настройка</h3>
            <ul>
                <li>Написание ТЗ проекта</li>
                <li>Выбор инструмента
                    <ul>
                        <li>Языки программирования</li>
                        <li>CMS или фреймворк</li>
                        <li>Какие бывают фреймворки</li>
                        <li>Знакомство с Laravel</li>
                        <li>Философия Laravel</li>
                        <li>Отличия от других фреймворков</li>
                    </ul>
                </li>
                <li>Установка</li>
                <li>Запуск
                    <ul>
                        <li>Через Artisan</li>
                        <li>LAMP, LNMP, OpenServer</li>
                        <li>VirtualBox</li>
                        <li>Vagrant</li>
                        <li>Homestead</li>
                        <li>Docker</li>
                    </ul>
                </li>
                <li>Тестовое окружение</li>
            </ul>
        </div>

        <div class="lesson">
            <h3>Тема 2: Архитектура проекта</h3>
            <ul>
                <li>Подходы
                    <ul>
                        <li>RAD</li>
                        <li>Service Layer</li>
                        <li>CQRS</li>
                        <li>Command Bus</li>
                    </ul>
                </li>
                <li>Стандартная аутентификация</li>
                <li>Миграции</li>
                <li>Сидеры</li>
                <li>Тесты</li>
                <li>Структура директорий
                    <ul>
                        <li>Плоская</li>
                        <li>По уровням</li>
                        <li>По модулям</li>
                    </ul>
                </li>
                <li>Установка шаблона</li>
                <li>Управление ресурсами</li>
                <li>Хлебные крошки</li>
                <li>Заготовки кабинетов пользователя, модератора и администратора</li>
                <li>Выбор архитектуры</li>
                <li>Собственная двухфакторная аутентификация</li>
            </ul>
        </div>

        <div class="lesson">
            <h3>Тема 3: Панель администратора</h3>
            <ul>
                <li>Администрирование пользователей</li>
                <li>Администрирование ролей и разрешений</li>
                <li>Вложенные рубрики</li>
                <li>База городов и областей</li>
                <li>Динамические атрибуты для рубрик</li>
                <li>Администрирование рубрик</li>
                <li>Администрирование регионов</li>
            </ul>
        </div>

        <div class="lesson">
            <h3>Тема 4: Управление объявлениями</h3>
            <ul>
                <li>Создание объявлений</li>
                <li>Определение координаты по адресу</li>
                <li>Модерирование</li>
                <li>Закрытие истекших объявлении по Cron</li>
                <li>Уведомление о закрытии или истечении</li>
                <li>Вывод объявлений</li>
                <li>Привязка Яндекс.Карт</li>
                <li>Переписка в объявлении</li>
                <li>Отправка писем и SMS в очереди</li>
                <li>Виджет похожих объявлений</li>
            </ul>
        </div>

        <div class="lesson">
            <h3>Тема 5: Дополнительные моменты</h3>
            <ul>
                <li>Геолокация для определения города по IP и в JS</li>
                <li>Избранное</li>
                <li>Уведомления об изменениях в избранном</li>
                <li>Поиск с ElasticSearch</li>
                <li>Платёжные системы и агрегаторы</li>
                <li>Платное поднятие объявлений</li>
            </ul>
        </div>

        <div class="lesson">
            <h3>Тема 6: Баннерная система</h3>
            <ul>
                <li>Кабинет рекламодателя</li>
                <li>Создание баннера</li>
                <li>Модерация</li>
                <li>Оплата счёта</li>
                <li>Уведомление о закрытии и истечении беннера</li>
            </ul>
        </div>

        <div class="lesson">
            <h3>Тема 7: JSON API</h3>
            <ul>
                <li>Аутентификация</li>
                <li>Ресурсы и бизнес-логика</li>
                <li>Генерация документации</li>
            </ul>
        </div>

        <div class="lesson">
            <h3>Тема 8: Опции и производительность</h3>
            <ul>
                <li>Кеширование</li>
                <li>Вынесение статики</li>
                <li>Рассылка</li>
                <li>Статические страницы</li>
                <li>Тикет-система</li>
                <li>Карта сайта</li>
            </ul>
        </div>

    </div>
</section>

<section>
    <div class="container" id="guarantee">
        <h2>Полная гарантия возврата средств</h2>
        <div class="row">
            <div class="col-sm-8 col-sm-offset-2">
                <div class="block">
                    <p>Если Вас что-то не устроит в начале просмотра или Вы просто передумаете, то я верну ваш платёж.</p>
                </div>
            </div>
        </div>
    </div>
    <div class="container" id="price">
        <h2>Приобрести записи</h2>
        <div class="row">
            <div class="col-sm-8 col-md-offset-2">
                <div class="price-item">
                    <p style="margin-bottom: 20px; text-align: center">Выберите удобный для Вас пакет участия</p>
                    <div class="block">
                        <p>Вы получите доступ к записям и дополнительным материалам.</p>
                        <p>Если возникнут проблемы с оплатой, не найдёте подходящего способа, <b style="color: #ba0000">захотите оплатить как юрлицо</b> или есть другой вопрос,<br />то напишите на почту <b><script>document.write('mai' + 'l@eli' + 'sdn.ru');</script></b> или <a target="_blank" style="text-decoration: underline" href="/contacts">в обратную связь</a>.</p>
                        <p>Принимаются и международные карты. При оплате картой вспомните, не установливали ли Вы в онлайн-банке лимиты на сумму платежа.</p>
                        <p>Если Вы юрлицо, то пришлите свои реквизиты, число участников и их email-ы.</p>
                    </div>
                    <p>Сразу приобрести полностью</p>
                    <div class="price-text">все <span>8</span> тем за <span>8800</span> руб:</div>
                    <div class="price-button"><a href="https://products.elisdn.ru/order/laravel-board/" target="_blank">Приобрести все записи</a></div>
                    <p>или внести предоплату</p>
                    <div class="price-text">первые <span>4</span> темы за <span>4400</span> руб:</div>
                    <div class="price-button"><a href="https://products.elisdn.ru/order/laravel-board-part-1/" target="_blank">Приобрести половину</a></div>
                    <p style="text-align: center; font-size: 14px">Если у вас есть скидка постоянного участника<br />(пришла на электронную почту, если Вы не отписывались),<br />то введите код купона в открывшуюся форму оплаты.</p>
                    <p style="text-align: center; font-size: 14px">Если Вас что-то не устроит в ходе участия или Вы просто передумаете,<br />то я верну весь ваш платёж.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<?= NotificationBar::widget(); ?>

<footer style="background: #e6e6e9">
    <div class="container">
        <p>
            Елисеев Дмитрий Николаевич<br />
            ИНН 570600870325<br />
            <script>document.write('mai' + 'l@eli' + 'sdn.ru');</script>
        </p>
        <p>
            <a rel="nofollow" href="<?= Url::to(['/page/default/privacy']); ?>">Политика конфиденциальности</a> |
            <a rel="nofollow" href="<?= Url::to(['/partner/default/index']); ?>">Партнёрская программа</a>
        </p>
    </div>
</footer>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<script>
$(document).on('click', 'a', function() {
    const href = $(this).attr('href');
    if (href.indexOf('#') === 0) {
        $('html, body').animate({scrollTop: $(href).position().top - 50 }, 800);
        return false;
    }
});
</script>
