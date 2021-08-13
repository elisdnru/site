<?php

declare(strict_types=1);

namespace tests\acceptance\landing;

use tests\AcceptanceTester;

final class LaravelBoardCest
{
    public function home(AcceptanceTester $I): void
    {
        $I->amOnPage('laravel-board');
        $I->seeResponseCodeIs(200);
        $I->see('Мастер-класс по разработке доски объявлений на Laravel Framework', 'title');
        $I->seeInSource('<meta name="robots" content="index, nofollow">');
        $I->seeInSource('<link href="http://localhost/laravel-board" rel="canonical">');
    }
}
