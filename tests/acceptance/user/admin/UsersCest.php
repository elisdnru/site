<?php

declare(strict_types=1);

namespace tests\acceptance\user\admin;

use tests\AcceptanceTester;
use tests\fixtures\user\UserFixture;

class UsersCest
{
    // phpcs:disable
    // PSR2.Method Declarations.Underscore
    public function _before(AcceptanceTester $I): void
    {
        $I->haveFixtures([
            'user' => UserFixture::class,
        ]);
    }

    public function guest(AcceptanceTester $I): void
    {
        $I->amLoggedInByUser();
        $I->amOnPage('user/admin/user');
        $I->seeResponseCodeIs(403);
    }

    public function index(AcceptanceTester $I): void
    {
        $I->amLoggedInByAdmin();
        $I->amOnPage('user/admin/user');
        $I->seeResponseCodeIs(200);
        $I->see('Пользователи', 'h1');
    }

    public function create(AcceptanceTester $I): void
    {
        $I->amLoggedInByAdmin();
        $I->amOnPage('user/admin/user/create');
        $I->seeResponseCodeIs(200);
        $I->see('Добавление пользователя', 'h1');
    }
}
