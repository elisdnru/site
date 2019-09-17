<?php

namespace app\modules\tinymce;

use app\modules\main\components\system\WebModule;

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
