<?php

namespace tests\acceptance\sitemap;

use tests\AcceptanceTester;

class HtmlCest
{
    public function success(AcceptanceTester $I): void
    {
        $I->amOnPage('sitemap');
        $I->seeResponseCodeIs(200);
        $I->see('Карта сайта', 'h1');
    }
}
