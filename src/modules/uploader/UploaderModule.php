<?php

namespace app\modules\uploader;

use app\modules\main\components\system\DWebModule;

class UploaderModule extends DWebModule
{
    public $controllerNamespace = __NAMESPACE__ . '\controllers';

    public function init()
    {
        parent::init();

        $this->setImport([
            'application.modules.uploader.components.*',
        ]);
    }

    public static function rules()
    {
        return [
            'upload/resize' => 'uploader/resize/index',
            'upload/images/<image:.+\/[a-f0-9]+_[0-9]+x[0-9]+\..+>' => 'uploader/download/thumb',
        ];
    }
}
