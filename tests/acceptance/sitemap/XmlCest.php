<?php

declare(strict_types=1);

namespace tests\acceptance\sitemap;

use tests\AcceptanceTester;

final class XmlCest
{
    public function success(AcceptanceTester $I): void
    {
        $I->amOnPage('sitemap.xml');
        $I->seeResponseCodeIs(200);
        $I->seeElement('urlset');

        $I->see('http://localhost/blog', 'loc');
        $I->see('http://localhost/products', 'loc');
        $I->see('http://localhost/portfolio', 'loc');
        $I->see('http://localhost/contacts', 'loc');
        $I->see('http://localhost/oop-week', 'loc');
        $I->see('http://localhost/yii2-shop', 'loc');
        $I->see('http://localhost/laravel-board', 'loc');
        $I->see('http://localhost/project-manager', 'loc');
    }
}
