<?php

declare(strict_types=1);

namespace app\modules\file\forms\admin;

use Override;
use yii\base\Model;
use yii\web\UploadedFile;

final class UploadForm extends Model
{
    /**
     * @var string|UploadedFile[]
     */
    public array|string $files = '';

    #[Override]
    public function rules(): array
    {
        return [
            ['files', 'file', 'maxFiles' => 5],
        ];
    }

    #[Override]
    public function attributeLabels(): array
    {
        return [
            'files' => 'Файлы',
        ];
    }
}
