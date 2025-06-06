<?php

declare(strict_types=1);

namespace tests\acceptance\blog\admin;

use tests\AcceptanceTester;
use tests\fixtures\blog\TagFixture;
use tests\fixtures\user\UserFixture;

/**
 * @psalm-api
 */
final class TagsCest
{
    public function _before(AcceptanceTester $I): void
    {
        $I->haveFixtures([
            'user' => UserFixture::class,
            'tag' => TagFixture::class,
        ]);
    }

    public function access(AcceptanceTester $I): void
    {
        $I->amLoggedInByUser();
        $I->amOnPage('blog/admin/tag');
        $I->seeResponseCodeIs(403);
    }

    public function index(AcceptanceTester $I): void
    {
        $I->amLoggedInByAdmin();
        $I->amOnPage('blog/admin/tag');
        $I->seeResponseCodeIs(200);
        $I->see('Метки записей блога', 'h1');
    }
}
