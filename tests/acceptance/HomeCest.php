<?php

declare(strict_types=1);

namespace tests\acceptance;

use tests\AcceptanceTester;

final class HomeCest
{
    public function success(AcceptanceTester $I): void
    {
        $I->amOnPage('');
        $I->see('Дмитрий Елисеев', 'h1');
        $I->see('Новое в Блоге');
        $I->dontSeeElement('.admin-bar');
    }
}
