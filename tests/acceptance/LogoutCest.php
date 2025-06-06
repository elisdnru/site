<?php

declare(strict_types=1);

namespace tests\acceptance;

use tests\AcceptanceTester;
use tests\fixtures\user\UserFixture;

/**
 * @psalm-api
 */
final class LogoutCest
{
    public function _before(AcceptanceTester $I): void
    {
        $I->haveFixtures([
            'user' => UserFixture::class,
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
