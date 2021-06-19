<?php

declare(strict_types=1);

namespace tests\acceptance;

use tests\AcceptanceTester;
use tests\fixtures\page\PageFixture;

class PageCest
{
    public function _before(AcceptanceTester $I): void
    {
        $I->haveFixtures([
            'page' => PageFixture::class,
        ]);
    }

    public function root(AcceptanceTester $I): void
    {
        $I->amOnPage('info');
        $I->seeResponseCodeIs(200);
        $I->see('Info', 'h1');
        $I->see('Info Title', 'title');
        $I->seeInSource('<p>Info Content</p>');
    }

    public function path(AcceptanceTester $I): void
    {
        $I->amOnPage('info/about');
        $I->seeResponseCodeIs(200);
        $I->see('About', 'h1');
        $I->see('About Title', 'title');
        $I->seeInSource('<p>About Content</p>');
    }

    public function notRoot(AcceptanceTester $I): void
    {
        $I->amOnPage('about');
        $I->seeResponseCodeIs(404);
    }

    public function domainReplace(AcceptanceTester $I): void
    {
        $I->amOnPage('domain');
        $I->seeResponseCodeIs(200);
        $I->see('Domain', 'h1');
        $I->see('Domain Title', 'title');
        $I->seeInSource('<p>https://elisdn.ru/domain</p>');
    }
}
