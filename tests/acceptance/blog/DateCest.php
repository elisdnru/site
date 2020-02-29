<?php

namespace tests\acceptance\blog;

use tests\AcceptanceTester;
use tests\fixtures\blog\CategoryFixture;
use tests\fixtures\blog\PostFixture;

class DateCest
{
    // phpcs:disable
    // PSR2.Method Declarations.Underscore
    public function _before(AcceptanceTester $I): void
    {
        $I->haveFixtures([
            'category' => CategoryFixture::class,
            'post' => PostFixture::class,
        ]);
    }

    public function year(AcceptanceTester $I): void
    {
        $I->amOnPage('blog/date/2019');
        $I->seeResponseCodeIs(200);
        $I->see('Записи от 2019', 'h1');
        $I->see('Записи за 2019', 'title');
    }

    public function yearMonth(AcceptanceTester $I): void
    {
        $I->amOnPage('blog/date/2019-09');
        $I->seeResponseCodeIs(200);
        $I->see('Записи от 2019-09', 'h1');
        $I->see('Записи за 2019-09', 'title');
    }

    public function yearMonthDay(AcceptanceTester $I): void
    {
        $I->amOnPage('blog/date/2019-09-12');
        $I->seeResponseCodeIs(200);
        $I->see('Записи от 2019-09-12', 'h1');
        $I->see('Записи за 2019-09-12', 'title');
    }

    public function page(AcceptanceTester $I): void
    {
        $I->amOnPage('blog/date/2019-09/page-2');
        $I->seeResponseCodeIs(200);
        $I->see('Записи от 2019-09', 'h1');
        $I->see('Записи за 2019-09 - Страница 2', 'title');
    }
}
