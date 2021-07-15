<?php

declare(strict_types=1);

namespace tests\acceptance\landing;

use tests\AcceptanceTester;

class Yii2ShopCest
{
    public function home(AcceptanceTester $I): void
    {
        $I->amOnPage('yii2-shop');
        $I->seeResponseCodeIs(200);
        $I->see('Мастер-класс по разработке интернет-магазина на Yii2 Framework', 'title');
        $I->seeInSource('<meta name="robots" content="index, nofollow">');
        $I->seeInSource('<link href="http://localhost/yii2-shop" rel="canonical">');
    }
}
