<?php

namespace Nalgoo\Logging\Tests\Exceptions;

class NonameClass
{
	public function doSomething(): void
	{
		try {
			$this->doInnerThing();
		} catch (TestException $e) {
			throw new NonameException('Alert', 0, $e);
		}
	}

	public function doOtherThing(): void
	{
		try {
			$this->doInnerThing();
		} catch (TestException) {
			throw new NonameException('Alert');
		}
	}

	private function doInnerThing(): void
	{
		throw new TestException('Why me?');
	}
}