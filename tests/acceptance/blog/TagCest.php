<?php

declare(strict_types=1);

namespace tests\acceptance\blog;

use tests\AcceptanceTester;
use tests\fixtures\blog\TagFixture;

class TagCest
{
    // phpcs:disable
    // PSR2.Method Declarations.Underscore
    public function _before(AcceptanceTester $I): void
    {
        $I->haveFixtures([
            'tag' => TagFixture::class,
        ]);
    }

    public function tag(AcceptanceTester $I): void
    {
        $I->amOnPage('blog/tag/Hard');
        $I->seeResponseCodeIs(200);
        $I->see('Hard', 'h1');
        $I->see('Hard', 'title');
    }

    public function wrong(AcceptanceTester $I): void
    {
        $I->amOnPage('blog/tag/Tag');
        $I->seeResponseCodeIs(200);
        $I->see('Блог', 'h1');
    }

    public function page(AcceptanceTester $I): void
    {
        $I->amOnPage('blog/tag/Hard/page-2');
        $I->seeResponseCodeIs(200);
        $I->see('Hard', 'h1');
        $I->see('Hard - Страница 2', 'title');
    }
}
