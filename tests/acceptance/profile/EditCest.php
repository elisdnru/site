<?php

namespace tests\acceptance\profile;

use tests\AcceptanceTester;
use tests\fixtures\user\UserFixture;

class EditCest
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
        $I->amOnPage('profile/edit');
        $I->see('Вход в аккаунт', 'h1');
    }

    public function user(AcceptanceTester $I): void
    {
        $I->amLoggedInByUser();
        $I->amOnPage('profile/edit');
        $I->see('Редактировать профиль', '.portlet-title');
    }
}
