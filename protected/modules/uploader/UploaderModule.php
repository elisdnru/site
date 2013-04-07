<?php

class UploaderModule extends DWebModule
{
    public function init()
    {
        parent::init();

        $this->setImport(array(
            'application.modules.uploader.components.*',
        ));
    }

    public static function system()
    {
        return true;
    }

    public static function rules()
    {
        return array(
            'upload/resize'=>'uploader/resize/index',
            'upload/images/.+/[a-f0-9]+_[0-9]+x[0-9]+\..+'=>'uploader/download/thumb',
        );
    }
}
