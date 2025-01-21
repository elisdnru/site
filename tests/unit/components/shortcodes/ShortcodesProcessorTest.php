<?php

declare(strict_types=1);

namespace tests\unit\components\shortcodes;

use app\components\shortcodes\ShortcodesProcessor;
use app\components\shortcodes\WidgetRenderer;
use Codeception\Test\Unit;
use yii\caching\CacheInterface;

/**
 * @psalm-api
 * @internal
 */
final class ShortcodesProcessorTest extends Unit
{
    public function testProcess(): void
    {
        $renderer = $this->createMock(WidgetRenderer::class);
        $renderer->expects(self::exactly(2))->method('render')
            ->willReturnCallback(
                static fn (string $class, array $attributes) => match ($match = [$class, $attributes]) {
                    ['One', ['age' => '21', 'name' => 'John']] => '<div>One, John</div>',
                    ['Two', []] => '<div>Two</div>',
                    ['Three', []] => '<div>Three</div>',
                    default => self::fail(json_encode($match))
                }
            );

        $cache = $this->createMock(CacheInterface::class);
        $cache->expects(self::exactly(2))->method('get')
            ->willReturnCallback(
                static fn (string $key) => match ($match = $key) {
                    'widget_One_{"age":"21","name":"John"}' => null,
                    'widget_Three_[]' => '<div>Three</div>',
                    default => self::fail(json_encode($match)),
                }
            );

        $cache->expects(self::once())->method('set')
            ->willReturnCallback(
                static fn (string $key, string $value, ?int $duration) => match ($match = [$key, $value, $duration]) {
                    ['widget_One_{"age":"21","name":"John"}', '<div>One, John</div>', 12] => null,
                    default => self::fail(json_encode($match)),
                }
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
