<?php

namespace tests\acceptance;

use tests\AcceptanceTester;

class EduCest
{
    public function index(AcceptanceTester $I): void
    {
        $I->amOnPage('edu');
        $I->seeResponseCodeIs(200);
        $I->see('База знаний', 'h1');
        $I->see('База знаний', 'title');
    }
}
