<?php

interface Logger
{
	public function writeln($message = '');
	public function write($message);
	public function writelnSuccess($message = 'OK');
	public function writeSuccess($message = 'OK');
	public function writelnError($message = 'FAIL');
	public function writeError($message = 'FAIL');
	public function writelnNotice($message);
	public function writeNotice($message);
}

class ConsoleLogger implements Logger
{
	public function writeln($message = '') {
		$this->write($message);
		echo PHP_EOL;
	}

	public function write($message) {
		echo "\033[37m" . $message . " \033[m";
	}

	public function writelnSuccess($message = 'OK') {
		$this->writeSuccess($message);
		echo PHP_EOL;
	}

	public function writeSuccess($message = 'OK') {
		echo "\033[32m[" . $message . "] \033[m";
	}

	public function writelnError($message = 'FAIL') {
		$this->writeError($message);
		echo PHP_EOL;
	}

	public function writeError($message = 'FAIL') {
		echo "\033[31m[" . $message . "] \033[m";
	}

	public function writelnNotice($message) {
		$this->writeNotice($message);
		echo PHP_EOL;
	}

	public function writeNotice($message) {
		echo "\033[m" . $message . " \033[m";
	}
}