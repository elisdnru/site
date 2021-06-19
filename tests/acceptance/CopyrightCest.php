<?php

declare(strict_types=1);

namespace tests\acceptance;

use tests\AcceptanceTester;

class CopyrightCest
{
    public function home(AcceptanceTester $I): void
    {
        $I->amOnPage('copyright');
        $I->seeResponseCodeIs(200);
        $I->see('Использование материалов', 'h1');
        $I->see('Использование материалов', 'title');
        $I->seeInSource('<meta name="robots" content="noindex, follow">');
    }
}
