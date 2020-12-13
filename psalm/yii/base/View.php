<?php

declare(strict_types=1);

namespace yii\base;

class View extends Component implements DynamicContentAwareInterface
{
    /**
     * @psalm-var array{
     *     breadcrumbs: array,
     *     admin: array<array-key, array{label: string, url: string|array}>
     * }
     */
    public $params = [];
    /**
     * @var ViewContextInterface|Controller
     */
    public $context;

    public function getDynamicPlaceholders()
    {
        // TODO: Implement getDynamicPlaceholders() method.
    }

    public function setDynamicPlaceholders($placeholders)
    {
        // TODO: Implement setDynamicPlaceholders() method.
    }

    public function addDynamicPlaceholder($name, $statements)
    {
        // TODO: Implement addDynamicPlaceholder() method.
    }
}
