<?php

namespace Zenify\DoctrineBehaviors\Tests\DI\Source;

use Zenify\DoctrineBehaviors\Contract\Loggable\LoggerInterface;


class DummyLogger implements LoggerInterface
{

	/**
	 * {@inheritdoc}
	 */
	public function process($message)
	{
	}

}
