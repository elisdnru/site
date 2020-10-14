<?php

namespace tests\acceptance;

use tests\AcceptanceTester;

class SubscribeCest
{
    public function home(AcceptanceTester $I): void
    {
        $I->amOnPage('subscribe');
        $I->seeResponseCodeIs(200);
        $I->see('Подписка на обновления', 'h1');
        $I->see('Подписка на обновления', 'title');
        $I->seeInSource('<meta name="robots" content="noindex, nofollow">');
        $I->seeElement('.subscribe-form');
    }

    public function activate(AcceptanceTester $I): void
    {
        $I->amOnPage('subscribe/activate');
        $I->seeResponseCodeIs(200);
        $I->see('Ещё чуть-чуть...', 'h1');
        $I->see('Ещё чуть-чуть...', 'title');
        $I->see('Подписка на обновления', '.breadcrumbs');
        $I->seeInSource('<meta name="robots" content="noindex, nofollow">');
    }

    public function success(AcceptanceTester $I): void
    {
        $I->amOnPage('subscribe/success');
        $I->seeResponseCodeIs(200);
        $I->see('Всё получилось!', 'h1');
        $I->see('Всё получилось!', 'title');
        $I->see('Подписка на обновления', '.breadcrumbs');
        $I->seeInSource('<meta name="robots" content="noindex, nofollow">');
    }
}
