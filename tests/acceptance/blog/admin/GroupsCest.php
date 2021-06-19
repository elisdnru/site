<?php

declare(strict_types=1);

namespace tests\acceptance\blog\admin;

use tests\AcceptanceTester;
use tests\fixtures\blog\GroupFixture;
use tests\fixtures\user\UserFixture;

class GroupsCest
{
    // phpcs:disable
    // PSR2.Method Declarations.Underscore
    public function _before(AcceptanceTester $I): void
    {
        $I->haveFixtures([
            'user' => UserFixture::class,
            'group' => GroupFixture::class,
        ]);
    }

    public function access(AcceptanceTester $I): void
    {
        $I->amLoggedInByUser();
        $I->amOnPage('blog/admin/group');
        $I->seeResponseCodeIs(403);
    }

    public function index(AcceptanceTester $I): void
    {
        $I->amLoggedInByAdmin();
        $I->amOnPage('blog/admin/group');
        $I->seeResponseCodeIs(200);
        $I->see('Тематические группы записей', 'h1');
    }
}
