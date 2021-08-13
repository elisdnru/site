<?php

declare(strict_types=1);

namespace tests\acceptance\portfolio\admin;

use tests\AcceptanceTester;
use tests\fixtures\portfolio\CategoryFixture;
use tests\fixtures\portfolio\WorkFixture;
use tests\fixtures\user\UserFixture;

final class WorksCest
{
    public function _before(AcceptanceTester $I): void
    {
        $I->haveFixtures([
            'user' => UserFixture::class,
            'category' => CategoryFixture::class,
            'work' => WorkFixture::class,
        ]);
    }

    public function access(AcceptanceTester $I): void
    {
        $I->amLoggedInByUser();
        $I->amOnPage('portfolio/admin/work');
        $I->seeResponseCodeIs(403);
    }

    public function index(AcceptanceTester $I): void
    {
        $I->amLoggedInByAdmin();
        $I->amOnPage('portfolio/admin/work');
        $I->seeResponseCodeIs(200);
        $I->see('Портфолио', 'h1');
    }

    public function create(AcceptanceTester $I): void
    {
        $I->amLoggedInByAdmin();
        $I->amOnPage('portfolio/admin/work/create');
        $I->seeResponseCodeIs(200);
        $I->see('Добавление работы', 'h1');
    }

    public function update(AcceptanceTester $I): void
    {
        $I->amLoggedInByAdmin();
        $I->amOnPage('portfolio/admin/work/2/update');
        $I->seeResponseCodeIs(200);
        $I->see('Редактирование работы', 'h1');
    }
}
