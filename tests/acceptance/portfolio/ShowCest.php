<?php

declare(strict_types=1);

namespace tests\acceptance\portfolio;

use tests\AcceptanceTester;
use tests\fixtures\portfolio\CategoryFixture;
use tests\fixtures\portfolio\WorkFixture;

class ShowCest
{
    // phpcs:disable
    // PSR2.Method Declarations.Underscore
    public function _before(AcceptanceTester $I): void
    {
        $I->haveFixtures([
            'categories' => CategoryFixture::class,
            'works' => WorkFixture::class,
        ]);
    }

    public function published(AcceptanceTester $I): void
    {
        $I->amOnPage('portfolio/category-2/1/work-1');
        $I->seeResponseCodeIs(200);
        $I->see('Work 1', 'h1');
        $I->see('Title 1', 'title');
        $I->seeInSource('<p>Work Content</p>');
    }

    public function draft(AcceptanceTester $I): void
    {
        $I->amOnPage('portfolio/2/post');
        $I->seeResponseCodeIs(404);
    }

    public function redirect(AcceptanceTester $I): void
    {
        $I->amOnPage('portfolio/1?from=fb');
        $I->seeResponseCodeIs(200);
        $I->seeInCurrentUrl('portfolio/category-2/1/work-1?from=fb');
    }

    public function wrong(AcceptanceTester $I): void
    {
        $I->amOnPage('portfolio/0/work');
        $I->seeResponseCodeIs(404);
    }
}
