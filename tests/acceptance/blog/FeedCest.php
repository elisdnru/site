<?php

namespace tests\acceptance\blog;

use tests\AcceptanceTester;

class FeedCest
{
    public function success(AcceptanceTester $I): void
    {
        $I->amOnPage('blog/feed');
        $I->seeResponseCodeIs(200);
        $I->seeElement('rss');
    }
}
