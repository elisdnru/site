<?php declare(strict_types=1);

use app\assets\BootstrapAsset;
use yii\helpers\Url;
use yii\web\View;

/**
 * @var View $this
 */
BootstrapAsset::register($this);

$this->title = 'Мастер-класс по разработке интернет-магазина на Yii2 Framework';
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
        .block .subject {
            font-weight: bold;
            text-align: center;
            margin: 0 0 30px 0;
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
        <h1>Проект под ключ<small style="color: #fff">Одиннадцатидневный практический мастер класс<br />по разработке проекта на фреймворке</small>&laquo;Интернет-магазин на Yii2&raquo;</h1>
    </div>
</section>

<section id="for">
    <div class="container">
        <div class="block">
            <p>Если хотите получить кучу эмоций и новых знаний, то приходите к нам на полноценный многодневный мастер-класс.<p>
            <p></p>
        </div>
        <h2>Присоединяйтесь, если Вы:</h2>
        <ul class="bul-list">
            <li>Занимаетесь разработкой на Yii2 Framework или планируете его изучить</li>
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
        <h2>Автор: Дмитрий Елисеев</h2>
        <div style="text-align: center">
            <p><img width="350" height="350" style="margin: 0" src="/landing/author.jpg" alt="Дмитрий Елисеев"/></p>
            <p>
                Программист с 2008 года.<br />
                Специализируется на теории и практике бэкенд-разработки.<br />
                Автор <a target="_blank" href="https://elisdn.ru">блога</a>,
                ведущий <a target="_blank" href="/blog/tag/%D0%92%D0%B5%D0%B1%D0%B8%D0%BD%D0%B0%D1%80">вебинаров</a>
                по веб-программированию,<br />
                автор интенсива &laquo;<a target="_blank" href="/oop-week">Неделя ООП</a>&raquo;.
            </p>
        </div>
    </div>
</section>

<section id="format">
    <div class="container">
        <h2>Формат и актуальность</h2>
        <div class="format-block">
            <ul>
                <li>Вы получите доступ к личному кабинету ученика со всеми инструкциями и информацией о каждом уроке.</li>
                <li>Уроки проводились в <b>онлайн-формате</b> в виде вебинаров-скринкастов с демонстрацией экрана и общением в чате.</li>
                <li>Записи и исходные коды проекта выложены в личный кабинет.</li>
                <li>Каждая тема занимает 1-3 урока. Суммарно получилось 13 уроков по 5-6 часов.</li>
                <li>Доступ к кабинету останется у Вас навсегда, поэтому можете пересматривать когда угодно.</li>
                <li>При разработке мы делали упор на архитектуру построения самого приложения, а не на код конкретной версии фреймворка. Поэтому мастер-класс актуален всегда.</li>
            </ul>
        </div>
    </div>
</section>

<section id="program">
    <div class="container">
        <h2>Программа интенсива</h2>

        <hr />

        <p>Чтобы проект был максимально полезным (по требованиям многих вакансий) изучим популярный стек технических вещей:</p>

        <ul class="bul-list">
            <li>виртуальные машины с Vagrant;</li>
            <li>тестируемая сервисная архитектура;</li>
            <li>продвинутое использование ActiveRecord;</li>
            <li>поиск с ElasticSearch;</li>
            <li>тестирование с PHPUnit + Codeception;</li>
            <li>очереди с Redis Queue;</li>
            <li>контроль доступа RBAC;</li>
            <li>подключение платёжных систем;</li>
            <li>Email и SMS оповещения;</li>
            <li>REST API для мобильных приложений;</li>
            <li>оптимизация производительности</li>
            <li>...и прочие приятные мелочи.</li>
        </ul>

    </div>
</section>

<section id="schedule">
    <div class="container">
        <h2>Расписание</h2>
        <p style="text-align: center">Пункты могут меняться местами в ходе мастер-класса, но суть остаётся.</p>

        <div class="lesson">
            <h3>1. Установка и настройка</h3>
            <ul>
                <li>Установка фреймворка
                    <ul>
                        <li>Инициализация конфигурации</li>
                        <li>Переход на Asset Packagist</li>
                    </ul></li>
                <li>Виртуальная машина VirtualBox + Vagrant</li>
                <li>Настройка IDE
                    <ul>
                        <li>Рабочие директории</li>
                        <li>Composer</li>
                        <li>Codeception</li>
                        <li>Git</li>
                        <li>SSH</li>
                        <li>Запуск тестов с виртуальной машины</li>
                    </ul></li>
                <li>Настройка приложения
                    <ul>
                        <li>Единая аутентификация</li>
                        <li>Единый кеш</li>
                        <li>Разделение UrlManager</li>
                        <li>ЧПУ</li>
                    </ul></li>
                <li>Шаблон AdminLTE для панели администратора</li>
            </ul>
        </div>

        <div class="lesson">
            <h3>2. Архитектура и пользователи</h3>
            <ul>
                <li>Подготовка архитектуры
                    <ul>
                        <li>Разделение ответственностей</li>
                        <li>Выделение доменного ядра</li>
                        <li>Введение репозиториев</li>
                        <li>Выделение сервисов</li>
                        <li>Управление доменными событиями</li>
                    </ul></li>
                <li>Пользователи
                    <ul>
                        <li>Сущность User</li>
                        <li>Подтверждение регистрации по Email</li>
                        <li>Регистрация через соцсети
                            <ul>
                                <li>Новый пользователь</li>
                                <li>Привязка соцсетей к существующему</li>
                            </ul></li>
                    </ul></li>
                <li>Личный кабинет пользователя</li>
                <li>Администрирование пользователей</li>
            </ul>
        </div>

        <div class="lesson">
            <h3>3. Товары и управление</h3>
            <ul>
                <li>Товары
                    <ul>
                        <li>Фотографии</li>
                        <li>Модификации товаров</li>
                        <li>Динамические атрибуты</li>
                        <li>Вложенные категории</li>
                        <li>Теги</li>
                        <li>Сопутствующие товары</li>
                        <li>Отзывы и рейтинг</li>
                    </ul></li>
                <li>Тестирование</li>
            </ul>
        </div>

        <div class="lesson">
            <h3>4. Администрирование и шаблон</h3>
            <ul>
                <li>Администрирование товаров
                    <ul>
                        <li>Бренды</li>
                        <li>Метки</li>
                        <li>Характеристики</li>
                        <li>Товары</li>
                    </ul></li>
                <li>Шаблон магазина
                    <ul>
                        <li>Натяжка вёрстки</li>
                        <li>Регистрация CSS и JS</li>
                        <li>Разделение подшаблонов</li>
                    </ul></li>
            </ul>
        </div>

        <div class="lesson">
            <h3>5. Вывод каталога</h3>
            <ul>
                <li>Страница каталога
                    <ul>
                        <li>Отображение карточками или списком</li>
                        <li>Сортировка по дате и цене</li>
                    </ul></li>
                <li>Карточка товара</li>
                <li>Виджет категорий</li>
                <li>Виджеты сопутствующих товаров</li>
                <li>Простой поиск MySQL</li>
                <li>Полноценный поиск ElasticSearch</li>
            </ul>
        </div>

        <div class="lesson">
            <h3>6. Избранное и корзина</h3>
            <ul>
                <li>Избранное</li>
                <li>Виджет корзины</li>
                <li>Страница корзины</li>
                <li>Добавление в корзину</li>
                <li>Личный кабинет покупателя
                    <ul>
                        <li>Страница избранного</li>
                    </ul></li>
                <li>Управление скидками</li>
            </ul>
        </div>

        <div class="lesson">
            <h3>7. Заказ</h3>
            <ul>
                <li>Методы доставки</li>
                <li>Методы оплаты</li>
                <li>Оформление заказа</li>
                <li>Оплата заказа
                    <ul>
                        <li>Страница оплаты</li>
                        <li>Платёжные системы</li>
                    </ul></li>
                <li>Заказы в кабинете покупателя</li>
                <li>Заказы в кабинете администратора</li>
                <li>Экспорт заказов</li>
            </ul>
        </div>

        <div class="lesson">
            <h3>8. Сопутствующие разделы</h3>
            <ul>
                <li>Информационные страницы</li>
                <li>Блог
                    <ul>
                        <li>Рубрики</li>
                        <li>Метки</li>
                        <li>Посты</li>
                        <li>Комментари</li>
                    </ul></li>
                <li>Визуальный редактор</li>
            </ul>
        </div>

        <div class="lesson">
            <h3>9. REST API</h3>
            <ul>
                <li>Написание тестов</li>
                <li>Аутентификация OAuth2</li>
                <li>API покупателя</li>
                <li>Автогенерация документации в Swagger</li>
            </ul>
        </div>

        <div class="lesson">
            <h3>10. Дополнительные вещи</h3>
            <ul>
                <li>Карта сайта</li>
                <li>Яндекс.Маркет</li>
                <li>Рассылка
                    <ul>
                        <li>Подписка при регистрации</li>
                        <li>Настройки в профиле</li>
                    </ul></li>
                <li>Триггерные письма
                    <ul>
                        <li>Появление в наличии</li>
                        <li>Снижение цены на избранное</li>
                        <li>...</li>
                    </ul></li>
                <li>SMS-оповещения</li>
            </ul>
        </div>

        <div class="lesson">
            <h3>11. События и производительность</h3>
            <ul>
                <li>Обзор возможных проблем</li>
                <li>Перенос статики на CDN</li>
                <li>Очередь событий</li>
                <li>Кеширование</li>
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
        <h2>Оформление участия</h2>
        <div class="row">
            <div class="col-sm-8 col-md-offset-2">
                <div class="price-item">
                    <div style="margin-bottom: 30px">
                        <p style="margin-bottom: 0; text-align: center">Интенсив завершён. Подключайтесь к нам:</p>
                    </div>
                    <div class="block">
                        <p>Вы получите доступ к записям всех уроков и дополнительным материалам.</p>
                        <p>Если возникнут проблемы с оплатой, не найдёте подходящего способа, <b style="color: #ba0000">захотите оплатить как юрлицо</b> или есть другой вопрос,<br />то напишите на почту <b><script>document.write('mai' + 'l@eli' + 'sdn.ru');</script></b> или <a target="_blank" style="text-decoration: underline" href="/contacts">в обратную связь</a>.</p>
                    </div>
                    <p>Приобрести записи:</p>
                    <div class="price-text">все <span>11</span> дней за <span>9950</span> руб:</div>
                    <div class="price-button"><a href="https://products.elisdn.ru/order/yii2-shop/" target="_blank">Приобрести все записи</a></div>
                    <div class="price-text">пробные <span>5</span> дней за <span>4975</span> руб:</div>
                    <p style="margin: 0; text-align: center; font-size: 13px; color: #999">Если Вам не понравятся пробные уроки, то я верну платёж</p>
                    <div class="price-button"><a href="https://products.elisdn.ru/order/yii2-shop-part-1/" target="_blank">Приобрести половину</a></div>
                    <p style="text-align: center; font-size: 14px">Если у вас есть скидка, то введите купон в открывшуюся форму оплаты.</p>
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
