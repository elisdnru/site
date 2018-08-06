<?php

class UploaderModule extends DWebModule
{
    public function init()
    {
        parent::init();

        $this->setImport([
            'application.modules.uploader.components.*',
        ]);
    }

    public static function system()
    {
        return true;
    }

    public static function rules()
    {
        return [
            'upload/resize' => 'uploader/resize/index',
            'upload/images/<image:.+\/[a-f0-9]+_[0-9]+x[0-9]+\..+>' => 'uploader/download/thumb',
        ];
    }
}
