<?php

namespace tests\acceptance\blog;

use tests\AcceptanceTester;
use tests\fixtures\blog\CategoryFixture;

class CategoryCest
{
    // phpcs:disable
    // PSR2.Method Declarations.Underscore
    public function _before(AcceptanceTester $I): void
    {
        $I->haveFixtures([
            'category' => [
                'class' => CategoryFixture::class,
                'dataFile' => codecept_data_dir() . 'fixtures/blog_categories.php'
            ],
        ]);
    }

    public function root(AcceptanceTester $I): void
    {
        $I->amOnPage('blog/category-2');
        $I->seeResponseCodeIs(200);
        $I->see('Category 2', 'h1');
        $I->see('Title 2', 'title');
    }

    public function notRoot(AcceptanceTester $I): void
    {
        $I->amOnPage('blog/category-1');
        $I->seeResponseCodeIs(404);
    }

    public function path(AcceptanceTester $I): void
    {
        $I->amOnPage('blog/category-2/category-1');
        $I->seeResponseCodeIs(200);
        $I->see('Category 1', 'h1');
        $I->see('Category 1', '.breadcrumbs');
    }

    public function page(AcceptanceTester $I): void
    {
        $I->amOnPage('blog/category-2/page-2');
        $I->seeResponseCodeIs(200);
        $I->see('Category 2', 'h1');
        $I->see('Title 2 - Страница 2', 'title');
    }
}