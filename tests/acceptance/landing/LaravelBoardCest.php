<?php

namespace tests\acceptance\landing;

use tests\AcceptanceTester;

class LaravelBoardCest
{
    public function home(AcceptanceTester $I): void
    {
        $I->amOnPage('laravel-board');
        $I->seeResponseCodeIs(200);
        $I->see('Мастер-класс по разработке доски объявлений на Laravel Framework', 'title');
        $I->seeInSource('<meta name="robots" content="index, nofollow">');
        $I->seeInSource('<link href="http://nginx:8081/laravel-board" rel="canonical">');
    }
}
