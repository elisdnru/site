<?php

namespace tests\acceptance\landing;

use tests\AcceptanceTester;

class OopWeekCest
{
    public function home(AcceptanceTester $I): void
    {
        $I->amOnPage('oop-week');
        $I->seeResponseCodeIs(200);
        $I->see('Неделя ООП – Онлайн-интенсив по объектно-ориентированному программированию', 'title');
        $I->seeInSource('<meta name="robots" content="index, nofollow">');
        $I->seeInSource('<link href="http://nginx:81/oop-week" rel="canonical">');
    }
}
