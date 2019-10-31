<?php

namespace tests\acceptance\portfolio;

use tests\AcceptanceTester;
use tests\fixtures\portfolio\CategoryFixture;

class HomeTest
{
    // phpcs:disable
    // PSR2.Method Declarations.Underscore
    public function _before(AcceptanceTester $I): void
    {
        $I->haveFixtures([
            'category' => CategoryFixture::class,
        ]);
    }

    public function home(AcceptanceTester $I): void
    {
        $I->amOnPage('portfolio');
        $I->seeResponseCodeIs(200);
        $I->see('Портфолио', 'h1');
        $I->see('Портфолио', 'title');
        $I->dontSee('Category 1', '.subpages');
        $I->see('Category 2', '.subpages');
    }

    public function page(AcceptanceTester $I): void
    {
        $I->amOnPage('portfolio/page-2');
        $I->seeResponseCodeIs(200);
        $I->see('Портфолио', 'h1');
        $I->see('Портфолио - Страница 2', 'title');
    }
}
