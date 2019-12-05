<?php

declare(strict_types=1);

namespace tests\integration\components\category;

use Codeception\Test\Unit;
use Yii;

class CategoryBehaviorTest extends Unit
{
    /**
     * @var \tests\IntegrationTester
     */
    protected $tester;
    /**
     * @var Category
     */
    private $model;

    // phpcs:disable
    // PSR2.Method Declarations.Underscore
    protected function _before()
    {
        if (!Yii::$app->db->getTableSchema(Category::model()->tableName())) {
            Yii::$app->db->createCommand()->createTable(Category::model()->tableName(), [
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

        $this->model = Category::model();
    }

    public function testArray(): void
    {
        self::assertEquals([
            0 => '1',
            1 => '2',
            2 => '3',
        ], $this->model->getArray());
    }

    public function testAssocList(): void
    {
        self::assertEquals([
            1 => 'First',
            2 => 'Second',
            3 => 'Third',
        ], $this->model->getAssocList());
    }

    public function testAliasList(): void
    {
        self::assertEquals([
            'first' => 'First',
            'second' => 'Second',
            'third' => 'Third',
        ], $this->model->getAliasList());
    }

    public function testUrlList(): void
    {
        self::assertEquals([
            '/first' => 'First',
            '/second' => 'Second',
            '/third' => 'Third',
        ], $this->model->getUrlList());
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
                'itemOptions' => ['class' => 'item_1'],
                'linkOptions' => [],
            ],
            2 => [
                'id' => '2',
                'label' => 'Second',
                'url' => '/second',
                'icon' => '',
                'active' => false,
                'itemOptions' => ['class' => 'item_2'],
                'linkOptions' => [],
            ],
            3 => [
                'id' => '3',
                'label' => 'Third',
                'url' => '/third',
                'icon' => '',
                'active' => false,
                'itemOptions' => ['class' => 'item_3'],
                'linkOptions' => [],
            ],
        ], $this->model->getMenuList());
    }

    public function testFindByAliasSuccess(): void
    {
        $category = $this->model->findByAlias('first');

        self::assertNotNull($category);
        self::assertEquals('first', $category->alias);
    }

    public function testFindByAliasNotFound(): void
    {
        $category = $this->model->findByAlias('unknown');

        self::assertNull($category);
    }

    public function testLinkActiveYes(): void
    {
        $group = $this->getCategory('first');
        Yii::$app->request->setQueryParams(['category' => 'first']);

        self::assertTrue($group->getLinkActive());
    }

    public function testLinkActiveNo(): void
    {
        $group = $this->getCategory('first');
        Yii::$app->request->setQueryParams(['category' => 'second']);

        self::assertFalse($group->getLinkActive());
    }

    private function getCategory(string $alias): Category
    {
        /** @var Category $group */
        $group = Category::model()->find('alias = :alias', ['alias' => $alias]);
        return $group;
    }
}
