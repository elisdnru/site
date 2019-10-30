<?php

namespace tests\acceptance\admin;

use tests\AcceptanceTester;
use tests\fixtures\user\UserFixture;

class HomeCest
{
    // phpcs:disable
    // PSR2.Method Declarations.Underscore
    public function _before(AcceptanceTester $I): void
    {
        $I->haveFixtures([
            'user' => [
                'class' => UserFixture::class,
                'dataFile' => codecept_data_dir() . 'fixtures/users.php'
            ]
        ]);
    }

    public function guest(AcceptanceTester $I): void
    {
        $I->amOnPage('admin');
        $I->dontSee('Панель управления', 'h1');
        $I->see('Вход в аккаунт', 'h1');
    }

    public function user(AcceptanceTester $I): void
    {
        $I->amLoggedInByUser();
        $I->amOnPage('admin');
        $I->dontSee('Панель управления', 'h1');
        $I->seeResponseCodeIs(403);
    }

    public function admin(AcceptanceTester $I): void
    {
        $I->amLoggedInByAdmin();
        $I->amOnPage('admin');
        $I->see('Панель управления', 'h1');
    }
}
