<?php

namespace tests\acceptance\portfolio;

use tests\AcceptanceTester;
use tests\fixtures\portfolio\CategoryFixture;

class CategoryCest
{
    // phpcs:disable
    // PSR2.Method Declarations.Underscore
    public function _before(AcceptanceTester $I): void
    {
        $I->haveFixtures([
            'category' => CategoryFixture::class,
        ]);
    }

    public function root(AcceptanceTester $I): void
    {
        $I->amOnPage('portfolio/category-2');
        $I->seeResponseCodeIs(200);
        $I->see('Category 2', 'h1');
        $I->see('Title 2', 'title');
    }

    public function notRoot(AcceptanceTester $I): void
    {
        $I->amOnPage('portfolio/category-1');
        $I->seeResponseCodeIs(404);
    }

    public function path(AcceptanceTester $I): void
    {
        $I->amOnPage('portfolio/category-2/category-1');
        $I->seeResponseCodeIs(200);
        $I->see('Category 1', 'h1');
        $I->see('Category 1', '.breadcrumbs');
    }

    public function page(AcceptanceTester $I): void
    {
        $I->amOnPage('portfolio/category-2/page-2');
        $I->seeResponseCodeIs(200);
        $I->see('Category 2', 'h1');
        $I->see('Title 2 - Страница 2', 'title');
    }
}
