<?php

declare(strict_types=1);

namespace app\modules\page\migrations;

use yii\db\Migration;

class M210125100813RenameMeta extends Migration
{
    public function safeUp(): bool
    {
        $this->renameColumn('pages', 'pagetitle', 'meta_title');
        $this->renameColumn('pages', 'description', 'meta_description');
        return true;
    }

    public function safeDown(): bool
    {
        $this->renameColumn('pages', 'meta_title', 'pagetitle');
        $this->renameColumn('pages', 'meta_description', 'description');
        return true;
    }
}
