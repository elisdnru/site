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
        $I->amLoggedInByAdmin();
        $I->amOnPage('');
        $I->see('Новое в Блоге');
        $I->seeElement('.adminbar');

        $I->amOnPage('logout');
        $I->see('Новое в Блоге');
        $I->dontSeeElement('.adminbar');
    }

    public function admin(AcceptanceTester $I): void
    {
        $I->amOnPage('logout');
        $I->see('Новое в Блоге');
    }
}