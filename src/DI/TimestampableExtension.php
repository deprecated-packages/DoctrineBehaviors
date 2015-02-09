<?php

/**
 * This file is part of Zenify
 * Copyright (c) 2012 Tomas Votruba (http://tomasvotruba.cz)
 */

namespace Zenify\DoctrineBehaviors\DI;

use Kdyby;
use Kdyby\Events\DI\EventsExtension;
use Knp\DoctrineBehaviors\Model\Timestampable\Timestampable;
use Knp\DoctrineBehaviors\ORM\Timestampable\TimestampableSubscriber;
use Nette\Utils\AssertionException;
use Nette\Utils\Validators;


class TimestampableExtension extends BehaviorExtension
{

	/**
	 * @var array
	 */
	private $default = [
		'isRecursive' => TRUE,
		'trait' => Timestampable::class
	];


	public function loadConfiguration()
	{
		$config = $this->getConfig($this->default);
		$this->validateConfigTypes($config);
		$builder = $this->getContainerBuilder();

		$builder->addDefinition($this->prefix('listener'))
			->setClass(TimestampableSubscriber::class, [
				'@' . $this->getClassAnalyzer()->getClass(),
				$config['isRecursive'],
				$config['trait']
			])
			->setAutowired(FALSE)
			->addTag(EventsExtension::TAG_SUBSCRIBER);
	}


	/**
	 * @throws AssertionException
	 */
	private function validateConfigTypes(array $config)
	{
		Validators::assertField($config, 'isRecursive', 'bool');
		Validators::assertField($config, 'trait', 'type');
	}

}
