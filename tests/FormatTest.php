<?php

namespace Nalgoo\Logging\Tests;

use Nalgoo\Logging\Format;
use Nalgoo\Logging\Tests\Exceptions\NonameClass;
use Nalgoo\Logging\Tests\Exceptions\NonameException;
use Nalgoo\Logging\Tests\Exceptions\TestException;
use PHPUnit\Framework\TestCase;

class FormatTest extends TestCase
{
	public function testException()
	{
		$noname = new NonameClass();

		try {
			$noname->doSomething();
		} catch (NonameException $e) {
			$output = Format::exception($e);
		}

		try {
			$noname->doOtherThing();
		} catch (NonameException $e) {
			$output = Format::exception($e);
		}
	}
}
