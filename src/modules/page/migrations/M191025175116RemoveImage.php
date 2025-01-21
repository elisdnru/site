<?php

declare(strict_types=1);

namespace app\modules\page\migrations;

use yii\db\Migration;

/**
 * @psalm-api
 */
final class M191025175116RemoveImage extends Migration
{
    public function safeUp(): bool
    {
        $this->dropColumn('pages', 'image');
        $this->dropColumn('pages', 'image_width');
        $this->dropColumn('pages', 'image_height');
        $this->dropColumn('pages', 'image_alt');
        return true;
    }

    public function safeDown(): bool
    {
        return false;
    }
}
