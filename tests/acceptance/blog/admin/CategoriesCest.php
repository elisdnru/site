<?php

declare(strict_types=1);

namespace tests\acceptance\blog\admin;

use tests\AcceptanceTester;
use tests\fixtures\blog\CategoryFixture;
use tests\fixtures\user\UserFixture;

final class CategoriesCest
{
    public function _before(AcceptanceTester $I): void
    {
        $I->haveFixtures([
            'user' => UserFixture::class,
            'category' => CategoryFixture::class,
        ]);
    }

    public function access(AcceptanceTester $I): void
    {
        $I->amLoggedInByUser();
        $I->amOnPage('blog/admin/category');
        $I->seeResponseCodeIs(403);
    }

    public function index(AcceptanceTester $I): void
    {
        $I->amLoggedInByAdmin();
        $I->amOnPage('blog/admin/category');
        $I->seeResponseCodeIs(200);
        $I->see('Категории блога', 'h1');
    }
}
