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
        $I->see('Официальный блог', 'h1');
    }

    public function page(AcceptanceTester $I): void
    {
        $I->amOnPage('blog/date/2019-09/page-2');
        $I->seeResponseCodeIs(200);
        $I->see('Официальный блог', 'h1');
    }
}
