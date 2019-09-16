<?php

declare(strict_types=1);

namespace app\commands\minimize;

use app\commands\CException;
use app\commands\minimize\Driver;
use app\commands\Exception;
use app\commands\minimize\TextProcessor;
use app\components\Logger;

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
