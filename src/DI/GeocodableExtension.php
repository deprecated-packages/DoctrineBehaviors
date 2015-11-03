<?php

/**
 * This file is part of Zenify
 * Copyright (c) 2012 Tomas Votruba (http://tomasvotruba.cz)
 */

namespace Zenify\DoctrineBehaviors\DI;

use Kdyby;
use Kdyby\Events\DI\EventsExtension;
use Knp\DoctrineBehaviors\Model\Geocodable\Geocodable;
use Knp\DoctrineBehaviors\ORM\Geocodable\GeocodableSubscriber;
use Nette\Utils\AssertionException;
use Nette\Utils\Validators;


class GeocodableExtension extends AbstractBehaviorExtension
{

	/**
	 * @var array
	 */
	private $default = [
		'isRecursive' => TRUE,
		'trait' => Geocodable::class,
		'geolocationCallable' => NULL
	];


	public function loadConfiguration()
	{
		$config = $this->getConfig($this->default);
		$this->validateConfigTypes($config);
		$builder = $this->getContainerBuilder();

		$geolocationCallable = $this->buildDefinition($config['geolocationCallable']);

		$builder->addDefinition($this->prefix('listener'))
			->setClass(GeocodableSubscriber::class, [
				'@' . $this->getClassAnalyzer()->getClass(),
				$config['isRecursive'],
				$config['trait'],
				$geolocationCallable ? '@' . $geolocationCallable->getClass() : $geolocationCallable
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
		Validators::assertField($config, 'geolocationCallable', NULL | 'type');
	}

}
