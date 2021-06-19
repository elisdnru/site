<?php

declare(strict_types=1);

namespace tests\acceptance\landing;

use tests\AcceptanceTester;

class GitComposerCest
{
    public function home(AcceptanceTester $I): void
    {
        $I->amOnPage('git-composer');
        $I->seeResponseCodeIs(200);
        $I->see('Git и Composer для начинающих', 'title');
        $I->seeInSource('<meta name="robots" content="index, nofollow">');
        $I->seeInSource('<link href="http://localhost:8081/git-composer" rel="canonical">');
    }
}
