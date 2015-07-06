<?php

/**
 * This file is part of Zenify
 * Copyright (c) 2012 Tomas Votruba (http://tomasvotruba.cz)
 */

namespace Zenify\DoctrineBehaviors\Loggable;

use Zenify\DoctrineBehaviors\Contract\Loggable\LoggerInterface;


class LoggerCallable
{

	/**
	 * @var LoggerInterface
	 */
	private $logger;


	public function __construct(LoggerInterface $logger)
	{
		$this->logger = $logger;
	}


	/**
	 * @param string $message
	 */
	public function __invoke($message)
	{
		$this->logger->process($message);
	}

}
