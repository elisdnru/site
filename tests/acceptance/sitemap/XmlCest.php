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

        $I->see('http://localhost:8081/blog', 'loc');
        $I->see('http://localhost:8081/products', 'loc');
        $I->see('http://localhost:8081/portfolio', 'loc');
        $I->see('http://localhost:8081/contacts', 'loc');
        $I->see('http://localhost:8081/oop-week', 'loc');
        $I->see('http://localhost:8081/yii2-shop', 'loc');
        $I->see('http://localhost:8081/laravel-board', 'loc');
        $I->see('http://localhost:8081/project-manager', 'loc');
    }
}
