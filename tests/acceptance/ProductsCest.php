<?php

namespace tests\acceptance;

use tests\AcceptanceTester;

class ProductsCest
{
    public function home(AcceptanceTester $I): void
    {
        $I->amOnPage('products');
        $I->seeResponseCodeIs(200);
        $I->see('Авторские продукты', 'h1');
        $I->see('Авторские продукты', 'title');
    }
}