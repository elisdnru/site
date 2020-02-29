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
        $I->amOnPage('blog/date/2016');
        $I->seeResponseCodeIs(200);
        $I->see('Записи от 2016', 'h1');
        $I->see('Записи за 2016', 'title');
        $I->see('Post 1', 'a');
    }

    public function yearOther(AcceptanceTester $I): void
    {
        $I->amOnPage('blog/date/2014');
        $I->seeResponseCodeIs(200);
        $I->see('Записи от 2014', 'h1');
        $I->see('Записи за 2014', 'title');
        $I->dontSee('Post 1', 'a');
    }

    public function yearMonth(AcceptanceTester $I): void
    {
        $I->amOnPage('blog/date/2016-12');
        $I->seeResponseCodeIs(200);
        $I->see('Записи от 2016-12', 'h1');
        $I->see('Записи за 2016-12', 'title');
        $I->see('Post 1', 'a');
    }

    public function yearMonthOther(AcceptanceTester $I): void
    {
        $I->amOnPage('blog/date/2016-10');
        $I->seeResponseCodeIs(200);
        $I->see('Записи от 2016-10', 'h1');
        $I->see('Записи за 2016-10', 'title');
        $I->dontSee('Post 1', 'a');
    }

    public function yearMonthDay(AcceptanceTester $I): void
    {
        $I->amOnPage('blog/date/2016-12-11');
        $I->seeResponseCodeIs(200);
        $I->see('Записи от 2016-12-11', 'h1');
        $I->see('Записи за 2016-12-11', 'title');
        $I->see('Post 1', 'a');
    }

    public function yearMonthDayOther(AcceptanceTester $I): void
    {
        $I->amOnPage('blog/date/2016-12-09');
        $I->seeResponseCodeIs(200);
        $I->see('Записи от 2016-12-09', 'h1');
        $I->see('Записи за 2016-12-09', 'title');
        $I->dontSee('Post 1', 'a');
    }

    public function page(AcceptanceTester $I): void
    {
        $I->amOnPage('blog/date/2019-09/page-2');
        $I->seeResponseCodeIs(200);
        $I->see('Записи от 2019-09', 'h1');
        $I->see('Записи за 2019-09 - Страница 2', 'title');
    }
}
