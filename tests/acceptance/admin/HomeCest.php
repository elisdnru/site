<?php

declare(strict_types=1);

namespace tests\acceptance\admin;

use tests\AcceptanceTester;
use tests\fixtures\user\UserFixture;

/**
 * @psalm-api
 */
final class HomeCest
{
    public function _before(AcceptanceTester $I): void
    {
        $I->haveFixtures([
            'user' => UserFixture::class,
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
