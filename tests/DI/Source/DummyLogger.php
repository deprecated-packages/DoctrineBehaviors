<?php

namespace Zenify\DoctrineBehaviors\Tests\DI\Source;

use Zenify\DoctrineBehaviors\Loggable\Logger;


class DummyLogger implements Logger
{

	/**
	 * @param mixed $message
	 */
	public function process($message)
	{
	}

}
