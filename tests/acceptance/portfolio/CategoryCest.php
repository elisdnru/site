<?php

declare(strict_types=1);

namespace tests\acceptance\portfolio;

use tests\AcceptanceTester;
use tests\fixtures\portfolio\CategoryFixture;
use tests\fixtures\portfolio\WorkFixture;

/**
 * @psalm-api
 */
final class CategoryCest
{
    public function _before(AcceptanceTester $I): void
    {
        $I->haveFixtures([
            'category' => CategoryFixture::class,
            'work' => WorkFixture::class,
        ]);
    }

    public function root(AcceptanceTester $I): void
    {
        $I->amOnPage('portfolio/category-2');
        $I->seeResponseCodeIs(200);
        $I->see('Category 2', 'h1');
        $I->see('Title 2', 'title');
        $I->seeInSource('<p>Category 2</p>');
        $I->seeInSource('<span>Work 1</span>');
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
        $I->seeInSource('<p>Category 1</p>');
        $I->dontSeeInSource('<span>Work 1</span>');
    }

    public function page(AcceptanceTester $I): void
    {
        $I->amOnPage('portfolio/category-2/page-2');
        $I->seeResponseCodeIs(200);
        $I->see('Category 2', 'h1');
        $I->see('Title 2 - Страница 2', 'title');
        $I->seeInSource('<p>Category 2</p>');
    }
}
