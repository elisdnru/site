<?php

namespace tests\acceptance;

use tests\AcceptanceTester;

class HomeCest
{
    public function success(AcceptanceTester $I): void
    {
        $I->amOnPage('');
        $I->see('Дмитрий Елисеев', 'h1');
        $I->see('Новое в Блоге');
        $I->dontSeeElement('.adminbar');
    }
}
