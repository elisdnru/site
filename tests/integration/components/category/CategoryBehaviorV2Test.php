<?php

declare(strict_types=1);

namespace tests\integration\components\category;

use app\components\category\models\CategoryQueryV2;
use Codeception\Test\Unit;
use tests\IntegrationTester;
use Yii;

class CategoryBehaviorV2Test extends Unit
{
    protected IntegrationTester $tester;

    private CategoryQueryV2 $query;

    // phpcs:disable
    // PSR2.Method Declarations.Underscore
    protected function _before()
    {
        if (!Yii::$app->db->getTableSchema(CategoryV2::tableName())) {
            Yii::$app->db->createCommand()->createTable(CategoryV2::tableName(), [
                'id' => 'int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY',
                'sort' => 'smallint(3) NOT NULL',
                'alias' => 'varchar(255) NOT NULL',
                'title' => 'varchar(255) NOT NULL',
            ])->execute();
        }

        Yii::$app->urlManager->addRules([new CategoryUrlRule()]);

        $this->tester->haveFixtures([
            'category' => CategoryV2Fixture::class
        ]);

        $this->query = CategoryV2::find();
    }

    public function testArray(): void
    {
        self::assertEquals([
            0 => '1',
            1 => '2',
            2 => '3',
        ], $this->query->getArray());
    }

    public function testAssocList(): void
    {
        self::assertEquals([
            1 => 'First',
            2 => 'Second',
            3 => 'Third',
        ], $this->query->getAssocList());
    }

    public function testAliasList(): void
    {
        self::assertEquals([
            'first' => 'First',
            'second' => 'Second',
            'third' => 'Third',
        ], $this->query->getAliasList());
    }

    public function testUrlList(): void
    {
        self::assertEquals([
            '/first' => 'First',
            '/second' => 'Second',
            '/third' => 'Third',
        ], $this->query->getUrlList());
    }

    public function testMenuList(): void
    {
        self::assertEquals([
            1 => [
                'id' => '1',
                'label' => 'First',
                'url' => '/first',
                'icon' => '',
                'active' => false,
            ],
            2 => [
                'id' => '2',
                'label' => 'Second',
                'url' => '/second',
                'icon' => '',
                'active' => false,
            ],
            3 => [
                'id' => '3',
                'label' => 'Third',
                'url' => '/third',
                'icon' => '',
                'active' => false,
            ],
        ], $this->query->getMenuList());
    }

    public function testFindByAliasSuccess(): void
    {
        $category = $this->query->findByAlias('first');

        self::assertNotNull($category);
        self::assertEquals('first', $category->alias);
    }

    public function testFindByAliasNotFound(): void
    {
        $category = $this->query->findByAlias('unknown');

        self::assertNull($category);
    }

    public function testLinkActiveYes(): void
    {
        $category = $this->getCategory('first');
        Yii::$app->request->setQueryParams(['category' => 'first']);

        self::assertTrue($category->getLinkActive());
    }

    public function testLinkActiveNo(): void
    {
        $category = $this->getCategory('first');
        Yii::$app->request->setQueryParams(['category' => 'second']);

        self::assertFalse($category->getLinkActive());
    }

    private function getCategory(string $alias): CategoryV2
    {
        /** @var CategoryV2 $category */
        $category = CategoryV2::findOne(['alias' => $alias]);
        return $category;
    }
}