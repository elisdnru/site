<?php

namespace tests\acceptance;

use tests\AcceptanceTester;

class ServicesCest
{
    public function home(AcceptanceTester $I): void
    {
        $I->amOnPage('services');
        $I->seeResponseCodeIs(200);
        $I->see('Услуги по интернет-разработке', 'h1');
        $I->see('Услуги по интернет-разработке', 'title');
    }
}
