<?php

namespace tests\acceptance;

use tests\AcceptanceTester;

class DonateCest
{
    public function home(AcceptanceTester $I): void
    {
        $I->amOnPage('donate');
        $I->seeResponseCodeIs(200);
        $I->see('Поддержать проект', 'h1');
        $I->see('Поддержать проект', 'title');
        $I->seeInSource('<meta name="robots" content="noindex, nofollow">');
    }
}
