<?php

declare(strict_types=1);

namespace app\modules\portfolio\migrations;

use Override;
use yii\db\Migration;

/**
 * @psalm-api
 */
final class M220605150613RemoveImageSize extends Migration
{
    #[Override]
    public function safeUp(): bool
    {
        $this->dropColumn('portfolio_works', 'image_width');
        $this->dropColumn('portfolio_works', 'image_height');
        return true;
    }

    #[Override]
    public function safeDown(): bool
    {
        $this->addColumn('portfolio_works', 'image_width', 'int(11) DEFAULT NULL');
        $this->addColumn('portfolio_works', 'image_height', 'int(11) DEFAULT NULL');
        return true;
    }
}
