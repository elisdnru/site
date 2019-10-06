<?php

namespace app\modules\tinymce;

use app\components\system\WebModule;

class TinymceModule extends WebModule
{
    public function getGroup()
    {
        return 'Прочее';
    }

    public function getName()
    {
        return 'Редактор TinyMce';
    }
}
