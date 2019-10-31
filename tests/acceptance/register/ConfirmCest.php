<?php

namespace tests\acceptance\register;

use tests\AcceptanceTester;
use tests\fixtures\user\UserFixture;

class ConfirmCest
{
    // phpcs:disable
    // PSR2.Method Declarations.Underscore
    public function _before(AcceptanceTester $I): void
    {
        $I->haveFixtures([
            'user' => UserFixture::class,
        ]);
    }

    public function success(AcceptanceTester $I): void
    {
        $I->amOnPage('join/confirm?code=confirm-token');
        $I->see('Регистрация подтверждена', '.flash-success');
    }

    public function wrong(AcceptanceTester $I): void
    {
        $I->amOnPage('join/confirm?code=wrong-token');
        $I->see('Запись о подтверждении не найдена', '.flash-error');
    }
}
