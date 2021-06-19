<?php

declare(strict_types=1);

namespace tests\acceptance;

use tests\AcceptanceTester;
use tests\fixtures\landing\LandingFixture;

class LandingCest
{
    public function _before(AcceptanceTester $I): void
    {
        $I->haveFixtures([
            'page' => LandingFixture::class,
        ]);
    }

    public function root(AcceptanceTester $I): void
    {
        $I->amOnPage('course');
        $I->seeResponseCodeIs(200);
        $I->seeInSource('<p>Course Content</p>');
    }

    public function path(AcceptanceTester $I): void
    {
        $I->amOnPage('course/success');
        $I->seeResponseCodeIs(200);
        $I->seeInSource('<p>Success Content</p>');
    }

    public function notRoot(AcceptanceTester $I): void
    {
        $I->amOnPage('success');
        $I->seeResponseCodeIs(404);
    }
}
