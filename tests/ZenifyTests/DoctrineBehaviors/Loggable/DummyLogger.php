<?php

namespace ZenifyTests\DoctrineBehaviorsTests\Loggable;

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
