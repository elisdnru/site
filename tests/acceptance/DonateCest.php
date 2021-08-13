<?php

declare(strict_types=1);

namespace tests\acceptance;

use tests\AcceptanceTester;

final class DonateCest
{
    public function home(AcceptanceTester $I): void
    {
        $I->amOnPage('donate');
        $I->seeResponseCodeIs(200);
        $I->see('Поддержать проект', 'h1');
        $I->see('Поддержать проект', 'title');
        $I->seeInSource('<meta name="robots" content="noindex, follow">');
    }
}
