<?php

declare(strict_types=1);

namespace tests\acceptance\portfolio\admin;

use tests\AcceptanceTester;
use tests\fixtures\portfolio\CategoryFixture;
use tests\fixtures\user\UserFixture;

/**
 * @psalm-api
 */
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
        $I->amOnPage('portfolio/admin/category');
        $I->seeResponseCodeIs(403);
    }

    public function index(AcceptanceTester $I): void
    {
        $I->amLoggedInByAdmin();
        $I->amOnPage('portfolio/admin/category');
        $I->seeResponseCodeIs(200);
        $I->see('Категории работ', 'h1');
    }
}
