<?php

declare(strict_types=1);

namespace yii\base;

class View extends Component implements DynamicContentAwareInterface
{
    /**
     * @psalm-var array{
     *     breadcrumbs: array<array-key, array|string>,
     *     admin: array<array-key, array{label: string, url: string|array}>
     * }
     */
    public $params = [];
    /**
     * @var Controller
     */
    public $context;

    public function getDynamicPlaceholders(): array
    {
        return [];
    }

    public function setDynamicPlaceholders($placeholders): void
    {
    }

    public function addDynamicPlaceholder($name, $statements): void
    {
    }
}
