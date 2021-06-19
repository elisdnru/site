<?php declare(strict_types=1);

use yii\helpers\Url;
use yii\web\View;

/**
 * @var View $this
 */
$this->title = 'Неделя ООП – Онлайн-интенсив по объектно-ориентированному программированию';
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

    @media (min-width: 768px) {
        .intro {
            min-height: 456px;
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
        color: #FFF;
        text-decoration: none;
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
        <h1>Третий поток <small style="color: #fff">онлайн-интенсива по изучению<br />объектно-ориентированного
                программирования</small>&laquo;Неделя ООП&raquo;</h1>
    </div>
</section>

<section id="for">
    <div class="container">
        <div class="block">
            <p>Многие просят меня обучить их какому-нибудь PHP-фреймворку, мотивируя это тем, что хотят перейти на новый
                уровень разработки. Но после собеседования часто оказывается, что они работали только с самописным кодом
                или с процедурными CMS, где толком не встречались с объектно-ориентированным подходом:
            <p>
            <div style="max-width: 886px; margin: 20px auto 10px auto;">
                <iframe
                    width="100%"
                    height="499"
                    src="https://www.youtube.com/embed/BjLMSNJLTsM?rel=0&amp;showinfo=0"
                    frameborder="0"
                    allowfullscreen
                ></iframe>
            </div>
            <p>Без знаний ООП изучать какой-либо фреймворк нет смысла. Поэтому решил провести отдельный интенсив по ООП
                на основе материала со своих уроков, дополнив новыми разделами про лучшие практики разработки и
                практическими примерами, чего порой не хватает во многих теоретических курсах.</p>

        </div>
        <h2>Для кого этот интенсив?</h2>
        <div class="row">
            <div class="col-sm-6">
                <h4 style="text-align: left">Получите море пользы, если Вы:</h4>
                <ul class="bul-list">
                    <li>Слышали об ООП, но так и не осилили изучить</li>
                    <li>Застряли на процедурном программировании</li>
                    <li>Хотите изучить какой-нибудь ООП-фреймворк</li>
                    <li>Не знаете, чем класс отличается от интерфейса</li>
                    <li>Хотите ознакомиться с хорошими практиками</li>
                    <li>Хотите разрабатывать удобные программы</li>
                    <li>Откладывали изучение ООП до сегодняшнего дня</li>
                </ul>
            </div>
            <div class="col-sm-6">
                <h4 style="text-align: left">Бессмыcленно проходить курс, если Вы:</h4>
                <ul class="bul-list">
                    <li>Уже и так всё это знаете</li>
                    <li>Считаете, что перенеся процедуры в класс получите объект</li>
                    <li>Не собираетесь переходить на фреймворки</li>
                    <li>Не верите что в курсах есть что-то интересное</li>
                    <li>Считаете что купив курс, в тот же миг всему научитесь</li>
                    <li>Хотите отложить изучение ещё на пару лет</li>
                    <li>Да и вообще, если во всём сомневаетесь</li>
                </ul>
            </div>
        </div>
        <p></p>
    </div>
</section>

<section>
    <div class="container">
        <h2>Присоединяйтесь, если Вы:</h2>
        <ul class="bul-list">
            <li>Не хотите стать типичным &laquo;пэхапешником&raquo;, над которыми часто смеются.</li>
            <li>Хотите допускать меньше ошибок в своём коде и уметь их находить.</li>
            <li>Хотите уметь держать сложность проекта под контролем, а не пускать его на самотёк.</li>
            <li>Стремитесь к повышению эстетического и технического качества кода.</li>
            <li>Собираетесь разрабатывать сложные проекты.</li>
            <li>Хотите больше думать о полезном коде, а не тратить кучу времени на рутину.</li>
            <li>Желаете знать сильные и слабые стороны фреймворков.</li>
            <li>Хотите научиться более качественно анализировать задачи.</li>
            <li>Хотите создавать легкотестируемый программный код.</li>
            <li>Хотите уметь понимать чужой код.</li>
            <li>Интересуетесь принципами и практиками программной архитектуры.</li>
            <li>Хотите провести этот месяц с пользой.</li>
            <li>Хотите понимать суть вопросов, которые Вам задают на собеседовании.</li>
        </ul>
    </div>
</section>

<section id="author">
    <div class="container">
        <h2>Автор: Дмитрий Елисеев</h2>
        <div style="text-align: center">
            <p><img width="400" height="400" style="margin: 0" src="/landing/author.jpg" alt="Дмитрий Елисеев" />
            </p>
            <p>
                Программист с 2008 года.<br />
                Специализируется на теории и практике бэкенд-разработки.<br />
                Автор <a target="_blank" href="https://elisdn.ru">блога</a> и ведущий
                <a target="_blank" href="https://elisdn.ru/blog/tag/%D0%92%D0%B5%D0%B1%D0%B8%D0%BD%D0%B0%D1%80">вебинаров</a>
                по веб-программированию.
            </p>
        </div>
    </div>
</section>

<section id="format">
    <div class="container">
        <h2>Формат участия</h2>
        <div class="format-block">
            <ul>
                <li>После заказа Вам предоставят доступ к <b>личному кабинету ученика</b> с записями всех уроков.</li>
                <li>Уроки были записаны в виде вебинаров-скринкастов с демонстрацией экрана и общением в чате.</li>
                <li>По любым техническим вопросом Вам будет дан ответ в <b>службе поддержки</b>.</li>
            </ul>
        </div>
    </div>
</section>

<section id="program">
    <div class="container">
        <h2>Программа интенсива</h2>
        <p style="font-weight: bold">За эти шесть насыщенных вечеров мы с вами:</p>
        <ul class="bul-list">
            <li>Узнаем, кому нужен ООП и кому не нужен.</li>
            <li>Научимся моделировать предметную область и разбивать сложную логику на объекты.</li>
            <li>Научимся использовать &laquo;чистое&raquo; ООП и узнаем, чем оно полезно.</li>
            <li>Разберёмся, что же такое &laquo;Модель&raquo; в MVC.</li>
            <li>Ответим на вопрос, куда же деть бизнес-логику.</li>
            <li>Узнаем, как делать &laquo;тонкие контроллеры&raquo;.</li>
            <li>Рассмотрим лучшие практики и принципы функционального программирования, применимые в ООП.</li>
            <li>Изучим основополагающие архитектурные принципы и паттерны.</li>
            <li>Научимся пользоваться Dependency Injection контейнерами: независимыми и встроенными в популярные
                фреймворки.
            </li>
            <li>Научимся писать понятный и тестируемый код, модульные тесты с PHPUnit.</li>
            <li>Узнаем нюансы написания легкотестируемого кода.</li>
            <li>Научимся писать фреймворконезависимый переносимый код, полюбим интерфейсы.</li>
            <li>Изучим устройство нескольких популярных высококачественных компонентов.</li>
            <li>Научимся активно использовать Composer для подключения пакетов.</li>
            <li>Научимся самостоятельно создавать гибкие и переносимые компоненты, чтобы экономить своё время.</li>
            <li>Напишем полноценное приложение на фреймворке.</li>
        </ul>
    </div>
</section>

<section id="schedule">
    <div class="container">
        <h2>Расписание</h2>
        <div class="row">
            <div class="col-sm-6">
                <div class="block">
                    <h3>День первый</h3>
                    <p class="subject">Философия: Что это, как и для чего</p>
                    <ul>
                        <li>Какие парадигмы программирования бывают</li>
                        <li>Отход от процедурного программирования к ООП</li>
                        <li>Кому и как объекты упрощают жизнь, а кому усложняют</li>
                        <li>Как придумывали объектно-ориентированную парадигму</li>
                        <li>Чем удобнее пользовательские типы и структуры данных</li>
                        <li>Динамическая память, указатели и сборщик мусора</li>
                        <li>Передача по ссылке и по значению</li>
                    </ul>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="block">
                    <h3>День второй</h3>
                    <p class="subject">Теория: Как пишутся классы</p>
                    <ul>
                        <li>Основные понятия и конструкции</li>
                        <li>Синтаксис, классы, поля и методы</li>
                        <li>Что же это за типы и что же это за классы</li>
                        <li>Поля и методы объекта</li>
                        <li>Области видимости. Какие когда предпочесть</li>
                        <li>Статические и динамические элементы</li>
                        <li>Плюсы и минусы строгой типизации</li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-6">
                <div class="block">
                    <h3>День третий</h3>
                    <p class="subject">Принципы: Как пишутся хорошие классы</p>
                    <ul>
                        <li>Мышление ООПэшного программиста</li>
                        <li>Почему неООПэшника сразу видно</li>
                        <li>Чем же абстрактный класс отличается от интерфейса</li>
                        <li>Наследуемся грамотно, избегая хаоса</li>
                        <li>Инкапсуляция и полиморфизм на примере</li>
                        <li>Использование принципов по-полной</li>
                        <li>Слова, которые все говорят, но лишь единицы понимают</li>
                    </ul>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="block">
                    <h3>День четвёртый</h3>
                    <p class="subject">Принципы: Как пишутся хорошие программы</p>
                    <ul>
                        <li>Написание понятного кода</li>
                        <li>Для чего нам нужен рефакторинг</li>
                        <li>ООП для укрощения сложности</li>
                        <li>Скажем дружно &laquo;нет лапшекоду&raquo;</li>
                        <li>Какие принципы проектирования существуют</li>
                        <li>Какие качества в себе нужно воспитать</li>
                        <li>Так ли это всё в реальной жизни</li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-6">
                <div class="block">
                    <h3>День пятый</h3>
                    <p class="subject">Свойства, методы, события, исключения</p>
                    <ul>
                        <li>Как не превратить проект в хаос</li>
                        <li>Взгляд на объект со стороны</li>
                        <li>Давать ли прямой доступ к свойствам</li>
                        <li>Создание и обработка событий (Event)</li>
                        <li>Использование исключений (Exception)</li>
                        <li>Делаем однонаправленные зависимости</li>
                        <li>Связи между уровнями абстракции</li>
                    </ul>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="block">
                    <h3>День шестой</h3>
                    <p class="subject">Практика: Как мы напишем программу</p>
                    <p style="margin-bottom: 42px">На основе изученных подходов и принципов придумываем автоматизацию
                        отдела кадров типового бизнеса: как спрограммировать приём сотрудников на работу и отправку в
                        отпуск, чтобы все были довольны.</p>
                    <p class="subject">Здесь подробно обсудим:</p>
                    <ul>
                        <li>Что важно для заказчика</li>
                        <li>Что важно для программиста</li>
                        <li>Плюсы и минусы ActiveRecord и CRUD</li>
                        <li>Куда поместить бизнес-логику... и прочие вещи</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>

<section>
    <div class="container" id="price">
        <h2>Оформление заказа</h2>
        <div class="row">
            <div class="col-sm-8 col-md-offset-2">
                <div class="price-item">
                    <div style="margin-bottom: 30px">
                        <p style="margin-bottom: 0; text-align: center">Интенсив прошёл с 14 по 25 ноября. Здесь Вы
                            можете приобрести записи с исходными кодами и списком дополнительной литературы.</p>
                    </div>
                    <div class="block">
                        <p>
                            Если возникнут проблемы с оплатой (например, с Webmoney), не найдёте подходящего способа или
                            есть другой вопрос, то напишите
                            <a target="_blank" style="text-decoration: underline" href="/contacts">в обратную связь</a>.
                        </p>
                    </div>
                    <div class="price-text"><span>6</span> дней по <span>5</span> часов за <span>5950</span> руб</div>
                    <div class="price-button">
                        <a href="//products.elisdn.ru/order/oop-week-3-a/" target="_blank">Приобрести записи</a>
                    </div>
                </div>
            </div>
        </div>
        <p style="color: #aaa; text-align: center">
            Принимаем
            <img alt="" src="//elisdn.justclick.ru/media/content/elisdn/payicons/alfabank-white.png" />
            <img alt="" src="//elisdn.justclick.ru/media/content/elisdn/payicons/visa.png" />
            <img alt="" src="//elisdn.justclick.ru/media/content/elisdn/payicons/mastercard.png" />
            <img alt="" src="//elisdn.justclick.ru/media/content/elisdn/payicons/webmoney-white.png" />
            <img alt="" src="//elisdn.justclick.ru/media/content/elisdn/payicons/yandexmoney.png" />
            <img alt="" src="//elisdn.justclick.ru/media/content/elisdn/payicons/sberbank.png" />
            и другие...
        </p>
    </div>
</section>

<footer style="background: #e6e6e9">
    <div class="container">
        <p>
            ИП Елисеев Дмитрий Николаевич<br />
            ОГРН 309574636200019 ИНН 570600870325<br />
            <script>document.write('mai' + 'l@eli' + 'sdn.ru')</script>
        </p>
        <p>
            <a rel="nofollow" href="<?= Url::to(['/page/default/privacy']); ?>">Политика конфиденциальности</a> |
            <a rel="nofollow" href="<?= Url::to(['/partner/default/index']); ?>">Партнёрская программа</a>
        </p>
    </div>
</footer>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<script>
$(document).on('click', 'a', function () {
    var href = $(this).attr('href')
    if (href.indexOf('#') === 0) {
        $('html, body').animate({ scrollTop: $(href).position().top - 50 }, 800)
        return false
    }
})
</script>
