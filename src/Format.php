<?php

namespace Nalgoo\Logging;

class Format
{
	private const EXCEPTION_MESSAGE_FORMAT = '%class% in %file% on line %line%';

	public static function exception(\Throwable $e): string
	{
		$result = [self::exceptionMessage($e)];

		$current = $e;
		while ($previous = $current->getPrevious()) {
			$result[] = self::exceptionMessage($previous, 'Caused by');
			$current = $previous;
		}

		// get stacktrace of first exception
		$result[] = self::stacktrace($current);

		return implode(PHP_EOL . PHP_EOL, $result);
	}

	/**
	 * @param \Throwable $e
	 * @param string $prefix
	 * @return string
	 */
	public static function exceptionMessage(\Throwable $e, string $prefix = 'Uncaught exception'): string
	{
		$lines = [
			ltrim(implode(' ', [$prefix, self::exceptionHeader($e) . ($e->getMessage() ? ':' : '')])),
			$e->getMessage(),
		];

		return implode(PHP_EOL, array_filter($lines));
	}

	public static function stacktrace(\Throwable $e): string
	{
		return implode(
			PHP_EOL,
			array_merge(
				['Stack trace:'],
				array_map(
					fn($trace, $idx) => sprintf(
						'%3d. %s(%d): %s%s%s()',
						$idx + 1,
						$trace['file'] ?? '[internal]',
						$trace['line'] ?? '??',
						$trace['class'] ?? '',
						$trace['type'] ?? '',
						$trace['function'] ?? '[unknown function]',
					),
					$e->getTrace(),
					array_keys($e->getTrace()),
				),
				[PHP_EOL],
			)
		);
	}

	private static function exceptionHeader(\Throwable $e): string
	{
		$parts = [
			'%class%' => Utils::getClass($e),
			'%file%' => $e->getFile(),
			'%line%' => (string) $e->getLine(),
		];

		return strtr(self::EXCEPTION_MESSAGE_FORMAT, $parts);
	}
}