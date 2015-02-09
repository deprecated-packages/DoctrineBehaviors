<?php

/**
 * This file is part of Zenify
 * Copyright (c) 2012 Tomas Votruba (http://tomasvotruba.cz)
 */

namespace Zenify\DoctrineBehaviors\Loggable;


class LoggerCallable
{

	/**
	 * @var Logger
	 */
	private $logger;


	public function __construct(Logger $logger)
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
