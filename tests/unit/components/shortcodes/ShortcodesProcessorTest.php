<?php

declare(strict_types=1);

namespace tests\unit\components\shortcodes;

use app\components\shortcodes\ShortcodesProcessor;
use app\components\shortcodes\WidgetRenderer;
use Codeception\Test\Unit;
use yii\caching\CacheInterface;

/**
 * @internal
 */
final class ShortcodesProcessorTest extends Unit
{
    public function testProcess(): void
    {
        $renderer = $this->createMock(WidgetRenderer::class);
        $renderer->expects(self::exactly(2))->method('render')
            ->withConsecutive(
                ['One', ['name' => 'John', 'age' => 21]],
                ['Two', []],
            )
            ->willReturnOnConsecutiveCalls(
                '<div>One, John</div>',
                '<div>Two</div>',
            );

        $cache = $this->createMock(CacheInterface::class);
        $cache->expects(self::exactly(2))->method('get')->withConsecutive(
            [self::stringContains('One')],
            [self::stringContains('Three')]
        )->willReturnOnConsecutiveCalls(
            null,
            '<div>Three</div>'
        );
        $cache->expects(self::once())->method('set')->withConsecutive(
            [self::stringContains('One'), '<div>One, John</div>', 12],
        );

        $processor = new ShortcodesProcessor([
            'one' => 'One',
            'two' => 'Two',
            'three' => 'Three',
        ], $renderer, $cache);

        $source = <<<'HTML'
            <h1>Hello!</h1>

            <p>[{widget:one|name=John;age=21;cache=12}]</p>
            <p>Appendix</p>

            <p>[{widget:two}]</p>
            <p>[{widget:three|cache=8}]</p>
            HTML;

        $expected = <<<'HTML'
            <h1>Hello!</h1>

            <div>One, John</div>
            <p>Appendix</p>

            <div>Two</div>
            <div>Three</div>
            HTML;

        $actual = $processor->process($source);

        self::assertEquals($expected, $actual);
    }
}
