<?php

declare(strict_types=1);

namespace tests\acceptance\landing\admin;

use tests\AcceptanceTester;
use tests\fixtures\landing\LandingFixture;
use tests\fixtures\user\UserFixture;

/**
 * @psalm-api
 */
final class LandingsCest
{
    public function _before(AcceptanceTester $I): void
    {
        $I->haveFixtures([
            'user' => UserFixture::class,
            'landing' => LandingFixture::class,
        ]);
    }

    public function access(AcceptanceTester $I): void
    {
        $I->amLoggedInByUser();
        $I->amOnPage('landing/admin/landing');
        $I->seeResponseCodeIs(403);
    }

    public function index(AcceptanceTester $I): void
    {
        $I->amLoggedInByAdmin();
        $I->amOnPage('landing/admin/landing');
        $I->seeResponseCodeIs(200);
        $I->see('Лендинги', 'h1');
    }

    public function create(AcceptanceTester $I): void
    {
        $I->amLoggedInByAdmin();
        $I->amOnPage('landing/admin/landing/create');
        $I->seeResponseCodeIs(200);
        $I->see('Добавление лендинга', 'h1');
    }
}
