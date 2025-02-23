<?php

declare(strict_types=1);

namespace app\modules\blog\migrations;

use Override;
use yii\db\Migration;

/**
 * @psalm-api
 */
final class M190806190154RemoveGallery extends Migration
{
    #[Override]
    public function safeUp(): bool
    {
        $this->dropColumn('{{blog_post}}', 'gallery_id');
        return true;
    }

    #[Override]
    public function safeDown(): bool
    {
        echo "m190806_190154_remove_gallery does not support migration down.\n";
        return false;
    }
}
