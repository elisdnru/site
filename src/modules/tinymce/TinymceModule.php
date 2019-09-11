<?php

namespace app\modules\tinymce;

use DWebModule;

class TinymceModule extends DWebModule
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
