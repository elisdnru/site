<?php

namespace tests\acceptance;

use tests\AcceptanceTester;
use tests\fixtures\user\UserFixture;

class LogoutCest
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

    public function user(AcceptanceTester $I): void
    {
        $I->amLoggedInByUser();
        $I->amOnPage('logout');
        $I->see('Новое в Блоге');
    }

    public function guest(AcceptanceTester $I): void
    {
        $I->amOnPage('logout');
        $I->see('Новое в Блоге');
    }
}
