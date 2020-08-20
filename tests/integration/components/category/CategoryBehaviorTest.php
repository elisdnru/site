<?php

declare(strict_types=1);

namespace tests\integration\components\category;

use app\components\category\models\CategoryQuery;
use Codeception\Test\Unit;
use tests\IntegrationTester;
use Yii;

class CategoryBehaviorTest extends Unit
{
    protected IntegrationTester $tester;

    private CategoryQuery $query;

    // phpcs:disable
    // PSR2.Method Declarations.Underscore
    protected function _before()
    {
        if (!Yii::$app->db->getTableSchema(Category::tableName())) {
            Yii::$app->db->createCommand()->createTable(Category::tableName(), [
                'id' => 'int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY',
                'sort' => 'smallint(3) NOT NULL',
                'alias' => 'varchar(255) NOT NULL',
                'title' => 'varchar(255) NOT NULL',
            ])->execute();
        }

        Yii::$app->urlManager->addRules([new CategoryUrlRule()]);

        $this->tester->haveFixtures([
            'category' => CategoryFixture::class
        ]);

        $this->query = Category::find();
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
                'active' => true,
            ],
            3 => [
                'id' => '3',
                'label' => 'Third',
                'url' => '/third',
                'icon' => '',
                'active' => false,
            ],
        ], $this->query->getMenuList('second'));
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

        self::assertTrue($category->isLinkActive('first'));
    }

    public function testLinkActiveNo(): void
    {
        $category = $this->getCategory('first');

        self::assertFalse($category->isLinkActive('second'));
    }

    private function getCategory(string $alias): Category
    {
        /** @var Category $category */
        $category = Category::findOne(['alias' => $alias]);
        return $category;
    }
}
