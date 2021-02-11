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
        $I->see('Карта сайта', 'title');

        $I->seeLink('Авторские продукты', '/products');
        $I->seeLink('Официальный блог', '/blog');
        $I->seeLink('Контактные данные', '/contacts');
        $I->seeLink('Неделя ООП', '/oop-week');
        $I->seeLink('Git и Composer для начинающих', '/git-composer');
    }
}
