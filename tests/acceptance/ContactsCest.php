<?php

declare(strict_types=1);

namespace tests\acceptance;

use tests\AcceptanceTester;

class ContactsCest
{
    public function home(AcceptanceTester $I): void
    {
        $I->amOnPage('contacts');
        $I->seeResponseCodeIs(200);
        $I->see('Елисеев Дмитрий Николаевич', 'h1');
        $I->see('Контактные данные', 'title');
    }
}
