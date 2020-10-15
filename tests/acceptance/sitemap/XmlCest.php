<?php

namespace tests\acceptance\sitemap;

use tests\AcceptanceTester;

class XmlCest
{
    public function success(AcceptanceTester $I): void
    {
        $I->amOnPage('sitemap.xml');
        $I->seeResponseCodeIs(200);
        $I->seeElement('urlset');

        $I->see('http://nginx:81/products', 'loc');
    }
}
