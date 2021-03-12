<?php

namespace tests\acceptance\landing;

use tests\AcceptanceTester;

class ProjectManagerCest
{
    public function home(AcceptanceTester $I): void
    {
        $I->amOnPage('project-manager');
        $I->seeResponseCodeIs(200);
        $I->see('Мастер-класс по разработке менеджера проектов', 'title');
        $I->seeInSource('<meta name="robots" content="index, nofollow">');
        $I->seeInSource('<link href="http://localhost:8081/project-manager" rel="canonical">');
    }
}
