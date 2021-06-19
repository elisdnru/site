<?php

declare(strict_types=1);

namespace tests\acceptance;

use tests\AcceptanceTester;

class PrivacyCest
{
    public function home(AcceptanceTester $I): void
    {
        $I->amOnPage('privacy');
        $I->seeResponseCodeIs(200);
        $I->see('Политика конфиденциальности', 'h1');
        $I->see('Политика конфиденциальности', 'title');
        $I->seeInSource('<meta name="robots" content="noindex, follow">');
    }
}
