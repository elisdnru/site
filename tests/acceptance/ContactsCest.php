<?php

declare(strict_types=1);

namespace tests\acceptance;

use tests\AcceptanceTester;

final class ContactsCest
{
    public function home(AcceptanceTester $I): void
    {
        $I->amOnPage('contacts');
        $I->seeResponseCodeIs(200);
        $I->see('Елисеев Дмитрий Николаевич', 'h1');
        $I->see('Контактные данные', 'title');
    }

    public function redirect(AcceptanceTester $I): void
    {
        $I->amOnPage('contact');
        $I->seeResponseCodeIs(200);
        $I->seeInCurrentUrl('contacts');
        $I->see('Елисеев Дмитрий Николаевич', 'h1');
        $I->see('Контактные данные', 'title');
    }
}
