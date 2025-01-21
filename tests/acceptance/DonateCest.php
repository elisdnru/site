<?php

declare(strict_types=1);

namespace tests\acceptance;

use tests\AcceptanceTester;

/**
 * @psalm-api
 */
final class DonateCest
{
    public function home(AcceptanceTester $I): void
    {
        $I->stopFollowingRedirects();
        $I->amOnPage('donate');
        $I->seeResponseCodeIs(302);
        $I->haveHttpHeader('Location', 'https://products.elisdn.ru/order/donate/');
    }
}
