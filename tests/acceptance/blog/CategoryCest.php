<?php

declare(strict_types=1);

namespace tests\acceptance\blog;

use tests\AcceptanceTester;
use tests\fixtures\blog\CategoryFixture;
use tests\fixtures\blog\PostFixture;

/**
 * @psalm-api
 */
final class CategoryCest
{
    public function _before(AcceptanceTester $I): void
    {
        $I->haveFixtures([
            'category' => CategoryFixture::class,
            'post' => PostFixture::class,
        ]);
    }

    public function root(AcceptanceTester $I): void
    {
        $I->amOnPage('blog/category-2');
        $I->seeResponseCodeIs(200);
        $I->see('Category 2', 'h1');
        $I->see('Title 2', 'title');
        $I->seeInSource('<p>Category 2</p>');
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
        $I->seeInSource('<p>Category 1</p>');
    }

    public function page(AcceptanceTester $I): void
    {
        $I->amOnPage('blog/category-2/page-2');
        $I->seeResponseCodeIs(200);
        $I->see('Category 2', 'h1');
        $I->see('Title 2 - Страница 2', 'title');
        $I->seeInSource('<p>Category 2</p>');
    }
}
