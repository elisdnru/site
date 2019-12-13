<?php

declare(strict_types=1);

namespace tests\integration\components\category;

use app\components\category\models\TreeCategoryQueryV2;
use Codeception\Test\Unit;
use tests\IntegrationTester;
use Yii;

class CategoryTreeBehaviorV2Test extends Unit
{
    protected IntegrationTester $tester;

    private TreeCategoryQueryV2 $find;

    // phpcs:disable
    // PSR2.Method Declarations.Underscore
    protected function _before()
    {
        if (!Yii::$app->db->getTableSchema(TreeCategoryV2::tableName())) {
            Yii::$app->db->createCommand()->createTable(TreeCategoryV2::tableName(), [
                'id' => 'int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY',
                'sort' => 'smallint(3) NOT NULL',
                'alias' => 'varchar(255) NOT NULL',
                'title' => 'varchar(255) NOT NULL',
                'parent_id' => 'int(11)',
            ])->execute();
        }

        Yii::$app->urlManager->addRules([new CategoryUrlRule()]);

        $this->tester->haveFixtures([
            'category' => TreeCategoryFixture::class,
        ]);

        $this->find = TreeCategoryV2::find();
    }

    public function testArray(): void
    {
        $this->markTestIncomplete();

        self::assertEquals([
            0 => '1',
            1 => '11',
            2 => '111',
            3 => '12',
            4 => '2',
            5 => '3',
        ], $this->find->getArray());
    }

    public function testAssocList(): void
    {
        $this->markTestIncomplete();

        self::assertEquals([
            1 => 'First Root',
            11 => 'First Root - First Root First Middle',
            111 => 'First Root - First Root First Middle - First Root First Middle Child',
            12 => 'First Root - First Root Second Middle',
            2 => 'Second Root',
            3 => 'Third Root',
        ], $this->find->getAssocList());
    }

    public function testAssocListParent(): void
    {
        $this->markTestIncomplete();

        self::assertEquals([
            1 => 'First Root',
            11 => 'First Root - First Root First Middle',
            111 => 'First Root - First Root First Middle - First Root First Middle Child',
            12 => 'First Root - First Root Second Middle',
        ], $this->find->getAssocList(1));
    }

    public function testAliasList(): void
    {
        $this->markTestIncomplete();

        self::assertEquals([
            'first-root' => 'First Root',
            'second-root' => 'Second Root',
            'third-root' => 'Third Root',
            'first-root-first-middle' => 'First Root First Middle',
            'first-middle-child' => 'First Root First Middle Child',
            'first-root-second-middle' => 'First Root Second Middle',
        ], $this->find->getAliasList());
    }

    public function testAliasListParent(): void
    {
        $this->markTestIncomplete();

        self::assertEquals([
            'first-root' => 'First Root',
            'first-root-first-middle' => 'First Root First Middle',
            'first-middle-child' => 'First Root First Middle Child',
            'first-root-second-middle' => 'First Root Second Middle',
        ], $this->find->getAliasList(1));
    }

    public function testTabList(): void
    {
        $this->markTestIncomplete();

        self::assertEquals([
            1 => 'First Root',
            11 => '-- First Root First Middle',
            111 => '-- -- First Root First Middle Child',
            12 => '-- First Root Second Middle',
            2 => 'Second Root',
            3 => 'Third Root',
        ], $this->find->getTabList());
    }

    public function testTabListParent(): void
    {
        $this->markTestIncomplete();

        self::assertEquals([
            11 => 'First Root First Middle',
            111 => '-- First Root First Middle Child',
            12 => 'First Root Second Middle',
        ], $this->find->getTabList(1));
    }

    public function testUrlList(): void
    {
        $this->markTestIncomplete();

        self::assertEquals([
            '/first-root' => 'First Root',
            '/first-root/first-root-first-middle' => '-- First Root First Middle',
            '/first-root/first-root-first-middle/first-middle-child' => '-- -- First Root First Middle Child',
            '/first-root/first-root-second-middle' => '-- First Root Second Middle',
            '/second-root' => 'Second Root',
            '/third-root' => 'Third Root',
        ], $this->find->getUrlList());
    }

    public function testUrlListParent(): void
    {
        $this->markTestIncomplete();

        self::assertEquals([
            '/first-root/first-root-first-middle' => 'First Root First Middle',
            '/first-root/first-root-first-middle/first-middle-child' => '-- First Root First Middle Child',
            '/first-root/first-root-second-middle' => 'First Root Second Middle',
        ], $this->find->getUrlList(1));
    }

    public function testMenuList(): void
    {
        $this->markTestIncomplete();

        self::assertEquals([
            1 => [
                'id' => '1',
                'label' => 'First Root',
                'url' => '/first-root',
                'icon' => '',
                'active' => false,
                'itemOptions' => ['class' => 'item_1'],
                'linkOptions' => [],
            ],
            2 => [
                'id' => '2',
                'label' => 'Second Root',
                'url' => '/second-root',
                'icon' => '',
                'active' => false,
                'itemOptions' => ['class' => 'item_2'],
                'linkOptions' => [],
            ],
            3 => [
                'id' => '3',
                'label' => 'Third Root',
                'url' => '/third-root',
                'icon' => '',
                'active' => false,
                'itemOptions' => ['class' => 'item_3'],
                'linkOptions' => [],
            ],
        ], $this->find->getMenuList());
    }

    public function testMenuListSub(): void
    {
        $this->markTestIncomplete();

        self::assertEquals([
            1 => [
                'id' => '1',
                'label' => 'First Root',
                'url' => '/first-root',
                'icon' => '',
                'active' => false,
                'itemOptions' => ['class' => 'item_1'],
                'linkOptions' => [],
                'items' => [
                    11 => [
                        'id' => '11',
                        'label' => 'First Root First Middle',
                        'url' => '/first-root/first-root-first-middle',
                        'icon' => '',
                        'active' => false,
                        'itemOptions' => ['class' => 'item_11'],
                        'linkOptions' => [],
                    ],
                    12 => [
                        'id' => '12',
                        'label' => 'First Root Second Middle',
                        'url' => '/first-root/first-root-second-middle',
                        'icon' => '',
                        'active' => false,
                        'itemOptions' => ['class' => 'item_12'],
                        'linkOptions' => [],
                    ],
                ],
            ],
            2 => [
                'id' => '2',
                'label' => 'Second Root',
                'url' => '/second-root',
                'icon' => '',
                'active' => false,
                'itemOptions' => ['class' => 'item_2'],
                'linkOptions' => [],
                'items' => [],
            ],
            3 => [
                'id' => '3',
                'label' => 'Third Root',
                'url' => '/third-root',
                'icon' => '',
                'active' => false,
                'itemOptions' => ['class' => 'item_3'],
                'linkOptions' => [],
                'items' => [],
            ],
        ], $this->find->getMenuList(1));
    }

    public function testMenuListSubParent(): void
    {
        $this->markTestIncomplete();

        self::assertEquals([
            11 => [
                'id' => '11',
                'label' => 'First Root First Middle',
                'url' => '/first-root/first-root-first-middle',
                'icon' => '',
                'active' => false,
                'itemOptions' => ['class' => 'item_11'],
                'linkOptions' => [],
                'items' => [
                    111 => [
                        'id' => '111',
                        'label' => 'First Root First Middle Child',
                        'url' => '/first-root/first-root-first-middle/first-middle-child',
                        'icon' => '',
                        'active' => false,
                        'itemOptions' => ['class' => 'item_111'],
                        'linkOptions' => [],
                    ],
                ],
            ],
            12 => [
                'id' => '12',
                'label' => 'First Root Second Middle',
                'url' => '/first-root/first-root-second-middle',
                'icon' => '',
                'active' => false,
                'itemOptions' => ['class' => 'item_12'],
                'linkOptions' => [],
                'items' => [],
            ],
        ], $this->find->getMenuList(1, 1));
    }

    public function testFindByAliasSuccess(): void
    {
        $this->markTestIncomplete();

        $category = $this->find->findByAlias('first-middle-child');

        self::assertNotNull($category);
        self::assertEquals('first-middle-child', $category->alias);
    }

    public function testFindByAliasNotFound(): void
    {
        $this->markTestIncomplete();

        $category = $this->find->findByAlias('unknown');

        self::assertNull($category);
    }

    public function testFindByPathSuccess(): void
    {
        $this->markTestIncomplete();

        $category = $this->find->findByPath('first-root/first-root-first-middle/first-middle-child');

        self::assertNotNull($category);
        self::assertEquals('first-middle-child', $category->alias);
    }

    public function testFindByPathNotFound(): void
    {
        $this->markTestIncomplete();

        $category = $this->find->findByPath('first-root/first-middle-child');

        self::assertNull($category);
    }

    public function testLinkActiveChild(): void
    {
        $this->markTestIncomplete();

        $category = $this->getCategory('first-root-first-middle');
        Yii::$app->request->setQueryParams(['category' => 'first-root/first-root-first-middle']);

        self::assertTrue($category->getLinkActive());
    }

    public function testLinkActiveRoot(): void
    {
        $this->markTestIncomplete();

        $category = $this->getCategory('first-root');
        Yii::$app->request->setQueryParams(['category' => 'first-root/first-root-first-middle']);

        self::assertTrue($category->getLinkActive());
    }

    public function testLinkActiveNo(): void
    {
        $this->markTestIncomplete();

        $category = $this->getCategory('first-root-second-middle');
        Yii::$app->request->setQueryParams(['category' => 'first-root/first-root-first-middle']);

        self::assertFalse($category->getLinkActive());
    }

    public function testChildrenArray(): void
    {
        $this->markTestIncomplete();

        self::assertEquals([
            0 => '1',
            1 => '11',
            2 => '111',
            3 => '12',
            4 => '2',
            5 => '3',
        ], $this->find->getChildrenArray());
    }

    public function testChildrenArrayParent(): void
    {
        $this->markTestIncomplete();

        self::assertEquals([
            0 => '11',
            1 => '111',
            2 => '12',
        ], $this->find->getChildrenArray(1));
    }

    public function testChildOfYes(): void
    {
        $this->markTestIncomplete();

        $parent = $this->getCategory('first-root');
        $child = $this->getCategory('first-middle-child');

        self::assertTrue($child->isChildOf($parent->id));
    }

    public function testChildOfNo(): void
    {
        $this->markTestIncomplete();

        $other = $this->getCategory('second-root');
        $child = $this->getCategory('first-middle-child');

        self::assertFalse($child->isChildOf($other->id));
    }

    public function testPath(): void
    {
        $this->markTestIncomplete();

        $category = $this->getCategory('first-middle-child');

        self::assertEquals('first-root/first-root-first-middle/first-middle-child', $category->getPath());
    }

    public function testBreadcrumbs(): void
    {
        $this->markTestIncomplete();

        $category = $this->getCategory('first-middle-child');

        self::assertEquals([
            'First Root' => '/first-root',
            'First Root First Middle' => '/first-root/first-root-first-middle',
            0 => 'First Root First Middle Child',
        ], $category->getBreadcrumbs());
    }

    public function testBreadcrumbsLastLink(): void
    {
        $this->markTestIncomplete();

        $category = $this->getCategory('first-middle-child');

        self::assertEquals([
            'First Root' => '/first-root',
            'First Root First Middle' => '/first-root/first-root-first-middle',
            'First Root First Middle Child' => '/first-root/first-root-first-middle/first-middle-child',
        ], $category->getBreadcrumbs(true));
    }

    public function testFullTitle(): void
    {
        $this->markTestIncomplete();

        $category = $this->getCategory('first-middle-child');

        self::assertEquals('First Root - First Root First Middle - First Root First Middle Child', $category->getFullTitle());
    }

    public function testFullTitleInverse(): void
    {
        $this->markTestIncomplete();

        $category = $this->getCategory('first-middle-child');

        self::assertEquals('First Root First Middle Child - First Root First Middle - First Root', $category->getFullTitle(true));
    }

    private function getCategory(string $alias): TreeCategory
    {
        /** @var TreeCategory $category */
        $category = TreeCategory::model()->find('alias = :alias', ['alias' => $alias]);
        return $category;
    }
}
