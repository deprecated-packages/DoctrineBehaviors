<?php

declare(strict_types=1);

/*
 * This file is part of Zenify
 * Copyright (c) 2012 Tomas Votruba (http://tomasvotruba.cz)
 */

namespace Zenify\DoctrineBehaviors\Loggable;

use Zenify\DoctrineBehaviors\Contract\Loggable\LoggerInterface;


final class LoggerCallable
{

	/**
	 * @var LoggerInterface
	 */
	private $logger;


	public function __construct(LoggerInterface $logger)
	{
		$this->logger = $logger;
	}


	public function __invoke(string $message)
	{
		$this->logger->process($message);
	}

}
