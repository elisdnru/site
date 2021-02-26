<?php

use yii\helpers\Url;
use yii\web\View;

/**
 * @var View $this
 */

$this->title = 'Git и Composer для начинающих';
?>

<?php $this->beginBlock('meta') ?>
<meta name="robots" content="index, nofollow">
<link href="https://fonts.googleapis.com/css?family=Roboto+Slab:400,700&amp;subset=latin,cyrillic-ext" rel="stylesheet">
<link href="https://fonts.googleapis.com/css?family=Roboto+Condensed:400italic,700italic,400,700&amp;subset=latin,cyrillic-ext,cyrillic" rel="stylesheet">
<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
<?php $this->endBlock() ?>

<?php $this->beginBlock('styles') ?>
<style>
    body {
        font-family: arial, sans-serif;
        font-size: 16px;
        color: #444;
        background: #fff;
    }

    section {
        padding: 30px 0 15px 0;
        border-top: 1px solid #ddd;
    }

    @media (min-width: 1200px) {
        .container {
            width: 970px;
        }
    }

    h1, h2 {
        line-height: 1.2;
        font-weight: normal;
        color: #235d94;
        margin: 0 0 20px 0;
        font-family: 'Roboto Condensed', serif;
        text-transform: uppercase;
    }

    h1 {
        margin: -10px 0 0 0;
        color: #333;
        text-align: center;
        font-size: 36px;
    }

    h1 small {
        font-size: 20px;
        color: #444;
    }

    h2 {
        color: #235d94;
        font-size: 28px;
        text-align: center;
    }

    h3 {
        font-size: 20px;
        font-weight: normal;
        color: #333;
        margin: 0 0 20px 0;
        font-family: 'Roboto Condensed', serif;
        text-align: center;
    }

    p, ul {
        padding: 0;
        margin: 0 0 20px 0;
    }

    p {
        line-height: 1.4;
    }

    ul {
        list-style: inside url('/landing/git-composer/yes.png');
    }

    li {
        margin: 20px 0;
        line-height: 1.4;
    }

    a  {
        color: #296dad;
        text-decoration: underline;
    }

    a.order-button, button {
        display: inline-block;
        font-family: 'Roboto Condensed', sans-serif;
        font-size: 24px;
        text-transform: uppercase;
        text-decoration: none;
        padding: 10px 60px;
        background: #3388d8;
        background: linear-gradient(#3388d8, #2a70b1);
        color: #fff;
        border: none;
        border-radius: 100px;
    }

    a.order-button:hover {
        color: #fff;
        text-decoration: none;
    }

    .price-button {
        cursor: pointer;
        background: #E63C5A;
        border-radius: 5px;
        display: inline-block;
        vertical-align: top;
        color: #FFF;
        padding: 11px 28px 14px;
        margin: 30px 0 45px 0;
        font: bold 24px 'Roboto Slab', serif;
    }

    .price-button a {
        color:#FFF;
        text-decoration:none;
    }

    footer {
        border-top: 1px solid #ddd;
        padding: 30px 0 10px 0;
        text-align: center;
        font-size: 13px;
        color: #666;
    }

    footer p {
        margin-bottom: 20px;
    }

    footer a {
        color: #666;
    }
</style>
<?php $this->endBlock() ?>

<section style="background: #e6e6e9">
    <div class="container">
        <h1><small style="display: block; text-align: center;">12-дневный практикум по работе с системами контроля версий</small>&laquo;Git и Composer для начинающих&raquo;</h1>
    </div>
</section>

<section>
    <div class="container">
        <div class="clearfix" style="margin-bottom: 30px; padding: 20px 20px 1px 20px; border: 2px dashed #aabace; background: #eeeeff; border-radius: 20px">
            <p style="float: right; margin: 0 0 20px 20px"><img width="150" height="150" style="margin: 0; border: 1px solid #ddd; border-radius: 300px" src="/landing/git-composer/photo.jpg" alt="Дмитрий Елисеев"/></p>
            <p>В обратной связи моего <a target="_blank" href="/">блога</a>, большей частью посвящённого веб-программированию, обнаружился повышенный интерес к работе с системой контроля версий Git и с пакетным менеджером Composer от тех, кто не сталкивался с ними ранее.<p>
            <p>Я решил не готовить серию банальных статей (коих и так полно) по этому поводу, а набрал группу учеников и провёл несколько уроков по внедрению систем контроля версий и пакетных менеджеров. Теперь выкладываю записи остальным желающим.</p>
        </div>
    </div>

    <div class="container">
        <h2>На практикуме Вы научитесь:</h2>
        <div class="row">
            <div class="col-sm-6">
                <ul>
                    <li>Корректно использовать системы контроля версий;</li>
                    <li>Избавитесь от необходимости хранения куч файлов;</li>
                    <li>Подключать открытые компоненты к своему проекту;</li>
                    <li>Загружать проект на сервер автоматически в терминале;</li>
                </ul>
            </div>
            <div class="col-sm-6">
                <ul>
                    <li>Выкладывать свои репозитории на GitHub;</li>
                    <li>Исправлять чужие проекты на GitHub;</li>
                    <li>Пользоваться клиентами с графическим интерфейсом;</li>
                    <li>Познакомитесь с групповой разработкой.</li>
                </ul>
            </div>
        </div>
    </div>
</section>

<section>
    <div class="container">
        <div style="max-width: 680px; margin: 0 auto">
            <iframe width="100%" height="412" src="https://www.youtube.com/embed/puMpFraUc80" frameborder="0" allowfullscreen></iframe>
        </div>
    </div>
</section>

<section>
    <div class="container">
        <h2>Чему вы не научитесь:</h2>
        <p>Это пошаговый практикум с подробной проработкой каждой базовой команды каждым учеником, а не насыщенный материалом курс лекций. В записи вырезаны паузы и нетематические разговоры, поэтому в записи длительность немного меньше. В него чисто физически не вошли всевозможные нюансы и профессиональные вещи с интересными названиями вроде &laquo;навешивание хуков автопроверки стиля PHP кода и запуска тестов при коммитах&raquo;, а также всевозможные списки атрибутов каждой команды.</p>
    </div>
</section>

<section>
    <div class="container">
        <h2>В чём отличие практикума от курса лекций</h2>
        <p>В курсах и на лекциях даётся много материала, но без практического применения. В практикуме же занятия целиком состоят из пошаговой практической проработки базовых вещей с учениками. С параллельным объяснением по ходу выполнения, исправлением ошибок и ответами на вопросы. Так что практикум будет очень полезен именно для новичков, которые хотят вместе с нами по шагам сделать свой первый коммит или ребэйс.</p>

        <p style="text-align: center; margin: 20px 0 40px 0"><a class="order-button" href="#order">Приобрести записи</a></p>
    </div>
</section>

<section style="background: #f3f3f3">
    <div class="container">
        <h2>Программа практикума</h2>
    </div>
</section>

<section>
    <div class="container" style="padding-top: 20px; padding-bottom: 20px; border-bottom: 1px dashed #bbb">
        <div class="row">
            <div class="col-lg-4 col-md-5 ">
                <div style="margin: 0 auto 30px auto; background: url('/landing/git-composer/lessons/01.png') -220px -110px no-repeat; width: 300px; height: 300px; border: 5px solid #ddd; border-radius: 300px"></div>
            </div>
            <div class="col-lg-8 col-md-7">
                <h3 style="text-align: left; margin-bottom: 30px">День 1: Знакомство с системами контроля версий</h3>
                <ul>
                    <li>Знакомство с участниками</li>
                    <li>Организационные моменты</li>
                    <li>Как мы пишем реферат: идеальный и реальный сценарии</li>
                    <li>Сложности резервного копирования</li>
                    <li>Оптимизируем бекапы</li>
                </ul>
            </div>
        </div>
    </div>
    <div class="container" style="padding-top: 20px; padding-bottom: 20px; border-bottom: 1px dashed #bbb">
        <div class="row">
            <div class="col-lg-4 col-md-5 ">
                <div style="margin: 0 auto 30px auto; background: url('/landing/git-composer/lessons/02.png') -400px -30px no-repeat; width: 300px; height: 300px; border: 5px solid #ddd; border-radius: 300px"></div>
            </div>
            <div class="col-lg-8 col-md-7">
                <h3 style="text-align: left; margin-bottom: 30px">День 2: Настройки и основные команды Git</h3>
                <ul>
                    <li>Первоначальная настройка Git</li>
                    <li>Создание репозитория</li>
                    <li>Индексация файлов</li>
                    <li>Создание снимков состояния</li>
                    <li>Простой просмотр истории изменений</li>
                </ul>
            </div>
        </div>
    </div>
    <div class="container" style="padding-top: 20px; padding-bottom: 20px; border-bottom: 1px dashed #bbb">
        <div class="row">
            <div class="col-lg-4 col-md-5 ">
                <div style="margin: 0 auto 30px auto; background: url('/landing/git-composer/lessons/03.png') -360px -100px no-repeat; width: 300px; height: 300px; border: 5px solid #ddd; border-radius: 300px"></div>
            </div>
            <div class="col-lg-8 col-md-7">
                <h3 style="text-align: left; margin-bottom: 30px">День 3: Ветвление и слияние</h3>
                <ul>
                    <li>Создание веток</li>
                    <li>Переключение между ветками</li>
                    <li>Слияние (merge)</li>
                </ul>
            </div>
        </div>
    </div>
    <div class="container" style="padding-top: 20px; padding-bottom: 20px; border-bottom: 1px dashed #bbb">
        <div class="row">
            <div class="col-lg-4 col-md-5 ">
                <div style="margin: 0 auto 30px auto; background: url('/landing/git-composer/lessons/04.png') 20px -80px no-repeat; width: 300px; height: 300px; border: 5px solid #ddd; border-radius: 300px"></div>
            </div>
            <div class="col-lg-8 col-md-7">
                <h3 style="text-align: left; margin-bottom: 30px">День 4: Перемещение, удаление, игнорирование</h3>
                <ul>
                    <li>Перемещение веток</li>
                    <li>Игнорирование файлов</li>
                    <li>Удаление и перемещение файлов</li>
                    <li>Отмена изменений</li>
                    <li>Исправление коммита</li>
                    <li>Удаление коммитов</li>
                </ul>
            </div>
        </div>
    </div>
    <div class="container" style="padding-top: 20px; padding-bottom: 20px; border-bottom: 1px dashed #bbb">
        <div class="row">
            <div class="col-lg-4 col-md-5 ">
                <div style="margin: 0 auto 30px auto; background: url('/landing/git-composer/lessons/05.png') -80px -60px no-repeat; width: 300px; height: 300px; border: 5px solid #ddd; border-radius: 300px"></div>
            </div>
            <div class="col-lg-8 col-md-7">
                <h3 style="text-align: left; margin-bottom: 30px">День 5: Работа в SmartGit</h3>
                <ul>
                    <li>Создание репозитория</li>
                    <li>Индексирование изменений и коммиты</li>
                    <li>Исправление коммитов</li>
                    <li>Создание веток</li>
                    <li>Слияние и переброс веток</li>
                </ul>
            </div>
        </div>
    </div>
    <div class="container" style="padding-top: 20px; padding-bottom: 20px; border-bottom: 1px dashed #bbb">
        <div class="row">
            <div class="col-lg-4 col-md-5 ">
                <div style="margin: 0 auto 30px auto; background: url('/landing/git-composer/lessons/06.png') -320px -20px no-repeat; width: 300px; height: 300px; border: 5px solid #ddd; border-radius: 300px"></div>
            </div>
            <div class="col-lg-8 col-md-7">
                <h3 style="text-align: left; margin-bottom: 30px">День 6: Многопользовательская работа</h3>
                <ul>
                    <li>Создание главного репозитория</li>
                    <li>Клонирование репозитория</li>
                    <li>Подключение главного репозитория</li>
                    <li>Синхронизация изменений</li>
                </ul>
            </div>
        </div>
    </div>
    <div class="container" style="padding-top: 20px; padding-bottom: 20px; border-bottom: 1px dashed #bbb">
        <div class="row">
            <div class="col-lg-4 col-md-5 ">
                <div style="margin: 0 auto 30px auto; background: url('/landing/git-composer/lessons/07.png') -40px -120px no-repeat; width: 300px; height: 300px; border: 5px solid #ddd; border-radius: 300px"></div>
            </div>
            <div class="col-lg-8 col-md-7">
                <h3 style="text-align: left; margin-bottom: 30px">День 7: Совместная разработка: практикум</h3>
                <ul>
                    <li>Генерация SSH-ключа</li>
                    <li>Клонирование репозитория</li>
                    <li>Создание своих коммитов и веток</li>
                    <li>Синхронизация изменений</li>
                </ul>
            </div>
        </div>
    </div>
    <div class="container" style="padding-top: 20px; padding-bottom: 20px; border-bottom: 1px dashed #bbb">
        <div class="row">
            <div class="col-lg-4 col-md-5 ">
                <div style="margin: 0 auto 30px auto; background: url('/landing/git-composer/lessons/08.png') -40px -280px no-repeat; width: 300px; height: 300px; border: 5px solid #ddd; border-radius: 300px"></div>
            </div>
            <div class="col-lg-8 col-md-7">
                <h3 style="text-align: left; margin-bottom: 30px">День 8: Дополнительные инструменты Git (ч. 1)</h3>
                <ul>
                    <li>Прятание в «карман» (stash)</li>
                    <li>Метки версий (tag)</li>
                    <li>Интерактивное индексирование</li>
                    <li>Слияние без fast-forward</li>
                </ul>
            </div>
        </div>
    </div>
    <div class="container" style="padding-top: 20px; padding-bottom: 20px; border-bottom: 1px dashed #bbb">
        <div class="row">
            <div class="col-lg-4 col-md-5 ">
                <div style="margin: 0 auto 30px auto; background: url('/landing/git-composer/lessons/09.png') -20px -200px no-repeat; width: 300px; height: 300px; border: 5px solid #ddd; border-radius: 300px"></div>
            </div>
            <div class="col-lg-8 col-md-7">
                <h3 style="text-align: left; margin-bottom: 30px">День 9: Дополнительные инструменты Git (ч. 2)</h3>
                <ul>
                    <li>Перезапись истории</li>
                    <li>Поиск ошибок</li>
                </ul>
            </div>
        </div>
    </div>
    <div class="container" style="padding-top: 20px; padding-bottom: 20px; border-bottom: 1px dashed #bbb">
        <div class="row">
            <div class="col-lg-4 col-md-5 ">
                <div style="margin: 0 auto 30px auto; background: url('/landing/git-composer/lessons/10.png') -60px -80px no-repeat; width: 300px; height: 300px; border: 5px solid #ddd; border-radius: 300px"></div>
            </div>
            <div class="col-lg-8 col-md-7">
                <h3 style="text-align: left; margin-bottom: 30px">День 10: Знакомство с GitHub</h3>
                <ul>
                    <li>Регистрация на GitHub</li>
                    <li>Создание репозитория</li>
                    <li>Подключение репозитория</li>
                    <li>Клонирование</li>
                    <li>Создание и отправка Pull Request</li>
                </ul>
            </div>
        </div>
    </div>
    <div class="container" style="padding-top: 20px; padding-bottom: 20px; border-bottom: 1px dashed #bbb">
        <div class="row">
            <div class="col-lg-4 col-md-5 ">
                <div style="margin: 0 auto 30px auto; background: url('/landing/git-composer/lessons/11.png') -270px -220px no-repeat; width: 300px; height: 300px; border: 5px solid #ddd; border-radius: 300px"></div>
            </div>
            <div class="col-lg-8 col-md-7">
                <h3 style="text-align: left; margin-bottom: 30px">День 11: Знакомство с пакетными менеджерами</h3>
                <ul>
                    <li>Повторное использование</li>
                    <li>Распространение библиотек</li>
                    <li>Несовместимость версий</li>
                    <li>Проблема зависимостей</li>
                    <li>Репозитории и социальный кодинг</li>
                    <li>Договорённости об оформлении</li>
                    <li>Экосистема пакетного менеджера</li>
                </ul>
            </div>
        </div>
    </div>
    <div class="container" style="padding: 30px 0;">
        <div class="row">
            <div class="col-lg-4 col-md-5 ">
                <div style="margin: 0 auto 30px auto; background: url('/landing/git-composer/lessons/12.png') -10px -90px no-repeat; width: 300px; height: 300px; border: 5px solid #ddd; border-radius: 300px"></div>
            </div>
            <div class="col-lg-8 col-md-7">
                <h3 style="text-align: left; margin-bottom: 30px">День 12: Использование Composer</h3>
                <ul>
                    <li>Установка Composer</li>
                    <li>Создание проекта</li>
                    <li>Поиск компонента на packagist.org</li>
                    <li>Установка компонента нужной версии</li>
                    <li>Подключение автозагрузчика</li>
                    <li>Написание консольного HelloWorld-приложения</li>
                </ul>
            </div>
        </div>
    </div>
</section>

<section>
    <div class="container">
        <h2>И вопросы. Куда ж без них :)</h2>

        <div style="margin-bottom: 20px; padding: 20px 20px 1px 20px; border: 1px solid #aabace; background: #f6f6f6; border-radius: 20px">
            <p style="font-weight: bold; font-style: italic">Как проходят занятия?</p>
            <p>Объясняется базовый материал и даются задания: какую команду вбить, куда посмотреть, спрашиваю что получилось и показываю на картинках что произошло и почему произошло именно так. По ходу отвечаю на вопросы и задаю свои. Участники выполняют предложенные им действия и пишут, понятно им это или нет. Потом мы дружно благодарим друг друга и говорим не по теме. Но это по большей части вырезано :)</p>
        </div>

        <div style="margin-bottom: 20px; padding: 20px 20px 1px 20px; border: 1px solid #aabace; background: #f6f6f6; border-radius: 20px">
            <p style="font-weight: bold; font-style: italic">Это для новичков или для профи? Много ли информации?</p>
            <p>С ветвлением и слиянием все шаги делаются всеми одновременно. После каждого этапа мы обсуждаем что получилось и есть ли вопросы. Но если взять, например, пункт &laquo;Создание и отправка Pull Request&raquo;, то все ученики делают форки, клонируют свои репозитории к себе. Потом первый по списку ученик создаёт ветку, создаёт коммит, отправляет в свой репозиторий и отправляет мне свой request. Я принимаю его коммит. Дальше все дружно стягивают его коммит к себе. Потом выбираем второго добровольца и делаем то же самое.</p>
            <p>Так что при практической проработке учениками и обсуждением это растягивается на несколько часов. Так что практикум будет полезен именно для новичков, которые хотят вместе с нами по шагам сделать свой первый коммит или ребэйс.</p>
        </div>

        <div style="margin-bottom: 20px; padding: 20px 20px 1px 20px; border: 1px solid #aabace; background: #f6f6f6; border-radius: 20px">
            <p style="font-weight: bold; font-style: italic">Почему не бесплатно?</p>
            <p>Хотел удалить этот ответ, но оставлю. Примерно 80% аудитории ходят в школу и институт только чтобы &laquo;попонтоваться&raquo; и в карты с приятелями поиграть. А оплатившие что-то самостоятельно люди всё-таки действительно приходят и учатся. Сам купил билет, но не сходил или выбросил &ndash; это редкость. Так что любая цена служит как фильтр адекватности.</p>
        </div>

        <div style="margin-bottom: 20px; padding: 20px 20px 1px 20px; border: 1px solid #aabace; background: #f6f6f6; border-radius: 20px">
            <p style="font-weight: bold; font-style: italic">Почему платно, если всё уже есть в сети и так?</p>
            <p>Да, вся информация бесплатна и получена из открытых источников. Оплачиваются только мои старания.</p>
        </div>
    </div>
</section>

<section style="background: #fff" id="order">
    <div class="container">
        <h2>Приобрести записи</h2>
    </div>
</section>

<section>
    <div class="container">
        <div class="row">
            <div class="col-lg-6" style="text-align: center">
                <img width="404" style="margin-bottom: 20px" src="/landing/git-composer/git-box.png" alt="" />
            </div>
            <div class="col-lg-6">

                <p style="text-align: center">Все <span style="font-size: 28px; color: #111">12</span> занятий за <span style="font-size: 28px; color: #f00">2400</span> руб.</p>

                <p style="font-size: 13px; text-align: center">Полная обратная связь по Email и персональное объяснение<br />вопросов, которые Вам могут показаться сложными.</p>

                <p style="font-size: 13px; text-align: center">Полная гарантия возврата средств:<br />если Вас что-то не устроит в начале просмотра<br />или Вы просто передумаете, то я верну ваш платёж.</p>

                <div style="width: 380px; margin: 0 auto 20px auto; text-align: center; padding: 10px 0 0 0; background: #eeeeff; border: 2px dashed #aabace; border-radius: 20px">
                    <div class="price-button"><a href="//products.elisdn.ru/order/gitcomposer-record/?required=surname" target="_blank">Приобрести записи</a></div>
                </div>

                <p style="font-size: 13px; text-align: center">Если есть какие-нибудь вопросы по практикуму,<br />по оплате или его формату и любые другие, то пишите<br />сразу мне по адресу <script>document.write('<b>mai' + 'l@eli' + 'sdn.ru</b>');</script><br />Заранее спасибо!</p>

            </div>
        </div>
    </div>
</section>

<footer style="background: #e6e6e9">
    <div class="container">
        <p>
            Принимаем
            <img alt="" src="//elisdn.justclick.ru/media/content/elisdn/payicons/visa.png" />
            <img alt="" src="//elisdn.justclick.ru/media/content/elisdn/payicons/mastercard.png" />
            <img alt="" src="//elisdn.justclick.ru/media/content/elisdn/payicons/webmoney-white.png" />
            <img alt="" src="//elisdn.justclick.ru/media/content/elisdn/payicons/yandexmoney.png" />
            <img alt="" src="//elisdn.justclick.ru/media/content/elisdn/payicons/qiwi.png" />
            и другие...
        </p>
        <p style="font-size: 13px">
            ИП Елисеев Дмитрий Николаевич<br />
            ОГРН 309574636200019 ИНН 570600870325<br />
            <script>document.write('mai' + 'l@eli' + 'sdn.ru');</script>
        </p>
        <p style="font-size: 13px">
            <a rel="nofollow" href="<?= Url::to(['/page/default/privacy']) ?>">Политика конфиденциальности</a> |
            <a rel="nofollow" href="<?= Url::to(['/partner/default/index']) ?>">Партнёрская программа</a>
        </p>
    </div>
</footer>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<script>
$(document).on('click', 'a', function() {
    var href = $(this).attr('href');
    if (href.indexOf('#') === 0) {
        $('html, body').animate({scrollTop: $(href).position().top }, 800);
        return false;
    }
});
</script>
