<?php

namespace tests\acceptance\profile;

use tests\AcceptanceTester;
use tests\fixtures\user\UserFixture;

class HomeCest
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
        $I->amOnPage('profile');
        $I->see('Вход в аккаунт', 'h1');
    }

    public function user(AcceptanceTester $I): void
    {
        $I->amLoggedInByUser();
        $I->amOnPage('profile');
        $I->see('Last User', 'h3');
    }

    public function admin(AcceptanceTester $I): void
    {
        $I->amLoggedInByAdmin();
        $I->amOnPage('profile');
        $I->see('Last Admin', 'h3');
    }
}
