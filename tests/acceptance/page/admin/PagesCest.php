<?php

declare(strict_types=1);

namespace tests\acceptance\page\admin;

use tests\AcceptanceTester;
use tests\fixtures\page\PageFixture;
use tests\fixtures\user\UserFixture;

class PagesCest
{
    public function _before(AcceptanceTester $I): void
    {
        $I->haveFixtures([
            'user' => UserFixture::class,
            'page' => PageFixture::class,
        ]);
    }

    public function access(AcceptanceTester $I): void
    {
        $I->amLoggedInByUser();
        $I->amOnPage('page/admin/page');
        $I->seeResponseCodeIs(403);
    }

    public function index(AcceptanceTester $I): void
    {
        $I->amLoggedInByAdmin();
        $I->amOnPage('page/admin/page');
        $I->seeResponseCodeIs(200);
        $I->see('Страницы', 'h1');
    }

    public function create(AcceptanceTester $I): void
    {
        $I->amLoggedInByAdmin();
        $I->amOnPage('page/admin/page/create');
        $I->seeResponseCodeIs(200);
        $I->see('Добавление страницы', 'h1');
    }
}
