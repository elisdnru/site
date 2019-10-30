<?php

namespace tests\acceptance\blog;

use tests\AcceptanceTester;

class HomeTest
{
    public function home(AcceptanceTester $I): void
    {
        $I->amOnPage('blog');
        $I->seeResponseCodeIs(200);
        $I->see('Блог', 'h1');
    }

    public function page(AcceptanceTester $I): void
    {
        $I->amOnPage('blog/page-2');
        $I->seeResponseCodeIs(200);
        $I->see('Блог', 'h1');
        $I->see('Блог - Страница 2', 'title');
    }
}
