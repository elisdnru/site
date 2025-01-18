<?php declare(strict_types=1);

use app\assets\BootstrapAsset;
use yii\helpers\Url;
use yii\web\View;

/**
 * @var View $this
 */
BootstrapAsset::register($this);

$this->title = 'Мастер-класс по разработке менеджера проектов';
?>

<?php $this->beginBlock('meta'); ?>
<meta name="robots" content="index, nofollow">
<link href="https://fonts.googleapis.com/css?family=Roboto+Slab:400,300,700&amp;subset=latin,cyrillic-ext" rel="stylesheet">
<link href="https://fonts.googleapis.com/css?family=Roboto+Condensed:300italic,400italic,700italic,400,300,700&amp;subset=latin,cyrillic-ext,cyrillic" rel="stylesheet">
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

<body>
<header class="hidden-xs">
    <nav class="navbar navbar-default navbar-fixed-top" role="navigation" style="margin-bottom: 0">
        <div class="container">
            <ul class="navbar-nav nav">
                <li><a href="#for">Для кого</a></li>
                <li><a href="#author">Автор</a></li>
                <li><a href="#format">Формат</a></li>
                <li><a href="#support">Поддержка</a></li>
                <li><a href="#program">Программа</a></li>
            </ul>
            <a href="#price" class="btn btn-danger navbar-btn pull-right">Получить записи</a>
        </div>
    </nav>
</header>

<section class="intro">
    <div class="container">
        <h1>Пятнадцатидневный<small style="color: #fff">практический мастер класс<br />по разработке проекта на фреймворке под ключ</small>&laquo;Разработка менеджера-проектов&raquo;</h1>
    </div>
</section>

<section id="for">
    <div class="container">
        <div class="block">
            <p>Если устали читать теорию и хотите применять Symfony Framework на практике, то приходите к нам на полноценный многодневный мастер-класс:<p>
            <div style="max-width: 886px; margin: 20px auto 10px auto;">
                <iframe width="100%" height="498" src="https://www.youtube.com/embed/HZ_HC-hUUpo?rel=0&amp;showinfo=0" frameborder="0" allowfullscreen></iframe>
            </div>
            <p>Все ваши предложения по его проведению мы обсудили в стриме:<p>
            <div style="max-width: 886px; margin: 20px auto 10px auto;">
                <iframe width="100%" height="498" src="https://www.youtube.com/embed/GYUTtMv4alg?rel=0&amp;showinfo=0" frameborder="0" allowfullscreen></iframe>
            </div>
            <p></p>
        </div>
        <h2>Присоединяйтесь, если Вы:</h2>
        <ul class="bul-list">
            <li>Занимаетесь разработкой на Symfony или планируете его изучить</li>
            <li>Разрабатываете на других фреймворках, но хотите перенять знания к себе в проект</li>
            <li>Испытываете сложности с документацией и хотите потренироваться на практике</li>
            <li>Хотите ознакомиться с новыми для себя архитектурными подходами</li>
            <li>Хотите перенять лучшие практики различных фреймворков</li>
            <li>Хотите потренироваться в применении знаний ООП или узнать, что это такое</li>
            <li>Хотите изучить модульное тестирование на реальных примерах</li>
            <li>Планируете заниматься разработкой REST API, его тестированием и документированием</li>
            <li>Планируете использовать общедоступные компоненты Symfony в своих проектах</li>
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
                Автор <a target="_blank" href="https://elisdn.ru">блога</a> и <a target="_blank" href="https://deworker.pro">скринкастов</a> по веб-программированию</a>&raquo;
            </p>
        </div>
    </div>
</section>

<section id="format">
    <div class="container">
        <h2>Формат и актуальность</h2>
        <div class="format-block">
            <ul>
                <li>Вы получите <b>доступ к личному кабинету ученика</b> со всеми инструкциями и необходимой информацией о каждом уроке.</li>
                <li>Уроки проводились в виде 3-4-часовых вебинаров-скринкастов с демонстрацией экрана и общением в чате.</li>
                <li><b>Записи в формате mp4, тайм-коды и исходные коды</b> проекта выложены в личном кабинете.</li>
                <li>Доступ к кабинету останется у Вас навсегда, поэтому можете пересматривать когда угодно.</li>
                <li>При разработке мы делали упор на архитектуру построения самого приложения, а не на код конкретной версии фреймворка. Поэтому мастер-класс актуален всегда.</li>
                <li>Первый <a href="/blog/130/enterprise-frameworks" target="_blank" style="text-decoration: underline">вводный урок</a> проведён бесплатно, поэтому в первой части оплачиваются 4 урока.</li>
            </ul>
        </div>
        <p style="text-align: center">По любым организационным и техническим вопросам Вам будет дан ответ в службе поддержки:</p>
    </div>
</section>

<section id="support" style="background: #f3f3f3">
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
        <h2>Что мы изучили</h2>

        <hr />

        <ul class="bul-list">
            <li>Философия Symfony в сравнении с другими фреймворками</li>
            <li>Выбор подходящих скелетонов для конкретного проекта</li>
            <li>Установка и настройка фреймворка</li>
            <li>Поднятие девелоперского окружения на Docker</li>
            <li>Сборка Docker-образов для выкладки в Staging или Production</li>
            <li>Использование и расширение популярных компонентов Symfony</li>
            <li>Использование компонентов Symfony отдельно в проектах на других фреймворках</li>
            <li>Написание слабосвязанного кода</li>
            <li>Практики применения подхода DDD (Domain Driven Development)</li>
            <li>Построение богатых моделей предметной области (Rich Domain Model)</li>
            <li>Построение доменных сущностей и агрегатов в Doctrine ORM</li>
            <li>Использование очередей и брокеров RabbitMQ для фоновых задач</li>
            <li>Использование шаблонизатора Twig и написание плагинов</li>
            <li>Программирование нестандартных форм ввода.</li>
            <li>Регистрация через элекронную почту и через соцсети</li>
            <li>Реализация умной системы прав и разрешений RBAC для менеджеров и исполнителей</li>
            <li>Написание универсального модуля комментариев</li>
            <li>Подключение и компиляция JavaScript-ассетов пакетом Encore</li>
            <li>Полнотекстовый поиск в PostgreSQL</li>
            <li>Разработка API для мобильных устройств</li>
            <li>Подключение OAuth2 для API</li>
            <li>Генерация документации для API</li>
            <li>Отправка Websocket-уведомлений через Centrifugo</li>
            <li>Оптимизация Dockerfile для ускорения сборки контейнеров для Production</li>
            <li>Вынесение загрузки пользовательских файлов на файловые хранилища</li>
            <li>Объектно-ориентированный анализ</li>
            <li>Модульное и интеграционное тестирование</li>
            <li>Лучшие практики и полезные паттерны проектирования</li>
        </ul>

        <p>...и другие полезные вещи</p>
    </div>
</section>

<section style="background: #f3f3f3">
    <div class="container">
        <h2>Содержание и результат</h2>
        <p>В мастер-классе мы разработали удобный менеджер проектов, который позволяет вести проекты компании, ставить задачи, назначать исполнителей, управлять ролями сотрудников, следить за выполнением и расписанием. Вы сможете взять код себе и доработать под свои задачи:</p>
    </div>
    <div style="max-width: 1280px; margin: 20px auto 10px auto;">
        <iframe width="100%" height="720" src="https://www.youtube.com/embed/j2hvBhxTSuQ?rel=0&amp;showinfo=0" frameborder="0" allowfullscreen></iframe>
    </div>
</section>

<section>
    <div class="container" id="guarantee">
        <h2>Полная гарантия возврата средств</h2>
        <div class="row">
            <div class="col-sm-8 col-sm-offset-2">
                <div class="block">
                    <p>Если Вас что-то не устроит в начале просмотра, то я верну ваш платёж.</p>
                </div>
            </div>
        </div>
    </div>
    <div class="container" id="price">
        <h2>Подключиться к нам</h2>
        <div class="row">
            <div class="col-sm-8 col-md-offset-2">
                <div class="price-item">
                    <div style="margin-bottom: 20px">
                        <p>Вы получите доступ к кабинету с записями всех уроков.</p>
                    </div>
                    <div class="block">
                        <p>Если возникнут проблемы с оплатой, не найдёте подходящего способа, <b style="color: #ba0000">захотите оплатить как юрлицо</b> или есть другой вопрос,<br />то напишите на почту <b><script>document.write('mai' + 'l@eli' + 'sdn.ru');</script></b> или <a target="_blank" style="text-decoration: underline" href="/contacts">в обратную связь</a>.</p>
                        <p>Принимаются и международные карты. При оплате картой вспомните, не установливали ли Вы в онлайн-банке лимиты на сумму платежа.</p>
                        <p>Если Вы юрлицо, то пришлите свои реквизиты, число участников и их email-ы. После прихода средств они получат доступы к записям и догонят остальных.</p>
                    </div>

                    <p>Приобрести в рассрочку:</p>
                    <div class="price-text"><span>1</span> вводный + <span>4</span> платных урока</div>
                    <div class="price-button"><a href="https://products.elisdn.ru/order/project-manager-part-1/" target="_blank">Приобрести первую треть</a></div>

                    <p>или приобрести целиком:</p>
                    <div class="price-text"><span>1</span> вводный + <span>14</span> платных уроков</div>
                    <div class="price-button"><a href="https://products.elisdn.ru/order/project-manager/" target="_blank">Приобрести все записи</a></div>

                    <p style="text-align: center; font-size: 14px; margin-bottom: 30px"><a href="/blog/130/enterprise-frameworks" target="_blank" style="text-decoration: underline">Посмотреть запись первого урока</a></p>

                    <p style="text-align: center; font-size: 14px">Если Вас что-то не устроит в начале просмотра,<br />то я верну ваш платёж.</p>
                </div>
            </div>
        </div>
    </div>
</section>

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
