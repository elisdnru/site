<?php

/**
 * Class MinimizeCommand
 *
 * <pre>
 * php yiic minimize all
 * </pre>
 */

class MinimizeCommand extends CConsoleCommand
{
    /** @var Handler */
    private $handler;

    public function init()
    {
        $this->handler = new Handler(new FileDriver(), new ConsoleLogger());
    }

    public function actionCss()
    {
        return $this->compileStyles() ? 0 : 1;
    }

    public function actionJs()
    {
        return $this->compileScripts() ? 0 : 1;
    }

    public function actionAll()
    {
        $styles = $this->compileStyles();
        $scripts = $this->compileScripts();
        return $styles && $scripts ? 0 : 1;
    }

    private function compileStyles()
    {
        $success = true;
        $processor = new CSSProcessor();
        foreach (Yii::app()->params['minimize_styles'] as $target => $sources) {
            $success = $this->handler->from($sources)->with($processor)->to($target)->process() && $success;
        }
        return $success;
    }

    private function compileScripts()
    {
        $success = true;
        $processor = new JSProcessor();
        foreach (Yii::app()->params['minimize_scripts'] as $target => $sources) {
            $success = $this->handler->from($sources)->with($processor)->to($target)->process() && $success;
        }
        return $success;
    }
}

class Handler
{
    /** @var array */
    private $sources = [];
    /** @var string */
    private $target = '';
    /** @var Driver */
    private $driver;
    /** @var Logger */
    private $log;
    /** @var TextProcessor */
    private $processor;

    public function __construct(Driver $driver, Logger $log)
    {
        $this->driver = $driver;
        $this->log = $log;
    }

    public function from(array $sources)
    {
        $this->sources = $sources;
        return $this;
    }

    public function to($target)
    {
        $this->target = $target;
        return $this;
    }

    public function with(TextProcessor $processor)
    {
        $this->processor = $processor;
        return $this;
    }

    public function process()
    {
        $this->checkOptions();
        $success = true;
        try {
            $this->log->writelnNotice('[ ' . get_class($this->processor) . ': ' . $this->target . ' ]');
            $result = '';
            foreach ($this->sources as $source) {
                $this->log->write('Process ' . $source);
                $text = $this->driver->load($source);
                if (strpos($source, '.min.') === false) {
                    $text = $this->processor->process($text);
                }
                $result .= $text . PHP_EOL;
                $this->log->writelnSuccess();
            }
            $this->log->write('Building ' . $this->target);
            $this->driver->save($this->target, $result);
            $this->log->writelnSuccess('COMPLETED');
        } catch (Exception $e) {
            $this->log->writelnError($e->getMessage());
            $this->log->write('Building ' . $this->target);
            $this->log->writelnError('ABORTED');
            $success = false;
        }
        return $success;
    }

    private function checkOptions()
    {
        if (!is_array($this->sources)) {
            throw new CException('Sources are not valid');
        }
        if (empty($this->target)) {
            throw new CException('Target is empty');
        }
        if ($this->processor === null) {
            throw new CException('Processor is empty');
        }
    }
}

interface TextProcessor
{
    public function process($text);
}

class CSSProcessor implements TextProcessor
{
    public function process($text)
    {
        $text = preg_replace('#[\s\t\r\n]+#s', ' ', $text);
        $text = preg_replace('#/\*.*?\*/\s*#s', '', $text);
        $text = preg_replace('#\}\s*#s', "}\n", $text);
        $text = preg_replace('#\n+#s', "\n", $text);
        return $text;
    }
}

class JSProcessor implements TextProcessor
{
    public function process($text)
    {
        $text = preg_replace('#[\r\n]+#s', "\n", $text);
        $text = preg_replace('#\t\n+#s', "\n", $text);
        $text = preg_replace('#\n+#s', "\n", $text);
        return $text;
    }
}

interface Driver
{
    public function load($source);

    public function save($target, $content);
}

class FileDriver implements Driver
{
    private $path;

    public function __construct()
    {
        $this->path = Yii::getPathOfAlias('application');
    }

    public function load($file)
    {
        $path = $this->getFullPath($file);
        $contents = @call_user_func_array('file_get_contents', [$path]);
        if ($contents === false) {
            throw new Exception('Failed to open ' . $file);
        } else {
            return $contents;
        }
    }

    public function save($file, $text)
    {
        $path = $this->getFullPath($file);
        $contents = @call_user_func_array('file_put_contents', [$path, $text]);
        if ($contents === false) {
            throw new Exception('Failed to write to ' . $file);
        }
    }

    private function getFullPath($filename)
    {
        $file = $this->path . '/' . $filename;
        return preg_replace('#[/\\\\]#', DIRECTORY_SEPARATOR, $file);
    }
}
