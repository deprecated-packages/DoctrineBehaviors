<?php

/**
 * This file is part of Zenify
 * Copyright (c) 2012 Tomas Votruba (http://tomasvotruba.cz)
 */

namespace Zenify\DoctrineBehaviors\DI;

use Nette\DI\CompilerExtension;
use Kdyby;


class LoggableExtension extends CompilerExtension
{
	use TClassAnalyzer;

	/** @var [] */
	protected $default = [
		'isRecursive' => TRUE,
		'loggerCallable' => 'Knp\DoctrineBehaviors\ORM\Loggable\LoggerCallable'
	];


	public function loadConfiguration()
	{
		$config = $this->getConfig($this->default);
		$builder = $this->getContainerBuilder();

		$builder->addDefinition($this->prefix('listener'))
			->setClass('Knp\DoctrineBehaviors\ORM\Loggable\LoggableListener', [
				'@' . $this->getClassAnalyzer()->getClass(),
				$config['isRecursive'],
				$config['loggerCallable']
			])
			->setAutowired(FALSE)
			->addTag(Kdyby\Events\DI\EventsExtension::TAG_SUBSCRIBER);
	}

}
