<?php
/**
 * A log-writer for Slim. Expects an existing Monolog logger
 * object.
 *
 * Some code borrowed from flynsarmy/slim-monolog.
 */

namespace Phrank\Extensions\Slim;

class LogWriter
{
	protected $logger;

	function __construct($logger)
	{
		$this->logger = $logger;
	}

	/**
	 * Converts Slim log level to Monolog log level
	 */
	protected $log_level = [
		\Slim\Log::EMERGENCY => \Monolog\Logger::EMERGENCY,
		\Slim\Log::ALERT     => \Monolog\Logger::ALERT,
		\Slim\Log::CRITICAL  => \Monolog\Logger::CRITICAL,
		\Slim\Log::ERROR     => \Monolog\Logger::ERROR,
		\Slim\Log::WARN      => \Monolog\Logger::WARNING,
		\Slim\Log::NOTICE    => \Monolog\Logger::NOTICE,
		\Slim\Log::INFO      => \Monolog\Logger::INFO,
		\Slim\Log::DEBUG     => \Monolog\Logger::DEBUG,
	];

	/**
	 * Write to log
	 *
	 * @param   mixed $object
	 * @param   int   $level
	 * @return  void
	 */
	public function write($object, $level)
	{
		if(!is_object($this->logger)) return;

		$this->logger->addRecord(
			$this->get_log_level($level, \Monolog\Logger::WARNING),
			$object
		);
	}

	/**
	 * Converts Slim log level to Monolog log level
	 *
	 * @param  int $slim_log_level   Slim log level we're converting from
	 * @param  int $default_level    Monolog log level to use if $slim_log_level not found
	 * @return int                   Monolog log level
	 */
	protected function get_log_level($slim_log_level, $default_monolog_log_level)
	{
		return isset($this->log_level[$slim_log_level])
			? $this->log_level[$slim_log_level]
			: $default_monolog_log_level;
	}
}
