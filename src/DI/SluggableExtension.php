<?php

/**
 * This file is part of Zenify
 * Copyright (c) 2012 Tomas Votruba (http://tomasvotruba.cz)
 */

namespace Zenify\DoctrineBehaviors\DI;

use Kdyby;
use Kdyby\Events\DI\EventsExtension;
use Knp\DoctrineBehaviors\Model\Sluggable\Sluggable;
use Knp\DoctrineBehaviors\ORM\Sluggable\SluggableSubscriber;
use Nette\Utils\AssertionException;
use Nette\Utils\Validators;


class SluggableExtension extends AbstractBehaviorExtension
{

	/**
	 * @var array
	 */
	protected $default = [
		'isRecursive' => TRUE,
		'trait' => Sluggable::class
	];


	public function loadConfiguration()
	{
		$config = $this->getConfig($this->default);
		$this->validateConfigTypes($config);
		$builder = $this->getContainerBuilder();

		$builder->addDefinition($this->prefix('listener'))
			->setClass(SluggableSubscriber::class, [
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
