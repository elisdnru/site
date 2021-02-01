<?php

namespace tests\acceptance;

use tests\AcceptanceTester;

class PartnerCest
{
    public function home(AcceptanceTester $I): void
    {
        $I->amOnPage('partner');
        $I->seeResponseCodeIs(200);
        $I->see('Парнёрская программа', 'h1');
        $I->see('Парнёрская программа', 'title');
        $I->seeLink('Подключиться к программе', 'https://products.elisdn.ru/join/');
    }
}
