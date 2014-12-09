<?php

/**
 * This file is part of Zenify
 * Copyright (c) 2012 Tomas Votruba (http://tomasvotruba.cz)
 */

namespace Zenify\DoctrineBehaviors\DI;

use Kdyby;
use Knp\DoctrineBehaviors\ORM\Loggable\LoggableListener;
use Nette;
use Nette\Utils\AssertionException;
use Nette\Utils\Validators;
use Zenify\DoctrineBehaviors\Loggable\LoggerCallable;


class LoggableExtension extends BehaviorExtension
{

	/**
	 * @var array
	 */
	private $default = [
		'isRecursive' => TRUE,
		'loggerCallable' => LoggerCallable::class
	];


	public function loadConfiguration()
	{
		$config = $this->getConfig($this->default);
		$this->validateConfigTypes($config);
		$builder = $this->getContainerBuilder();

		$loggerCallable = $this->buildDefinition($config['loggerCallable']);

		$builder->addDefinition($this->prefix('listener'))
			->setClass(LoggableListener::class, [
				'@' . $this->getClassAnalyzer()->getClass(),
				$config['isRecursive'],
				'@' . $loggerCallable->getClass()
			])
			->setAutowired(FALSE)
			->addTag(Kdyby\Events\DI\EventsExtension::TAG_SUBSCRIBER);
	}


	/**
	 * @throws AssertionException
	 */
	private function validateConfigTypes(array $config)
	{
		Validators::assertField($config, 'isRecursive', 'bool');
		Validators::assertField($config, 'loggerCallable', 'type');
	}

}
