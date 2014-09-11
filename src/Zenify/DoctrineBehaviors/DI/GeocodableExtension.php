<?php

/**
 * This file is part of Zenify
 * Copyright (c) 2012 Tomas Votruba (http://tomasvotruba.cz)
 */

namespace Zenify\DoctrineBehaviors\DI;

use Kdyby;
use Nette\Utils\AssertionException;
use Nette\Utils\Validators;


class GeocodableExtension extends BehaviorExtension
{
	/** @var array */
	protected $default = [
		'isRecursive' => TRUE,
		'trait' => 'Knp\DoctrineBehaviors\Model\Geocodable\Geocodable',
		'geolocationCallable' => NULL
	];


	public function loadConfiguration()
	{
		$config = $this->getConfig($this->default);
		$this->validateConfig($config);
		$builder = $this->getContainerBuilder();

		$geolocationCallable = $this->buildDefinition($config['geolocationCallable']);

		$builder->addDefinition($this->prefix('listener'))
			->setClass('Knp\DoctrineBehaviors\ORM\Geocodable\GeocodableListener', [
				'@' . $this->getClassAnalyzer()->getClass(),
				$config['isRecursive'],
				$config['trait'],
				$geolocationCallable ? '@' . $geolocationCallable->getClass() : $geolocationCallable
			])
			->setAutowired(FALSE)
			->addTag(Kdyby\Events\DI\EventsExtension::TAG_SUBSCRIBER);
	}


	/**
	 * @param array $config
	 * @throws AssertionException
	 */
	protected function validateConfig($config)
	{
		Validators::assertField($config, 'isRecursive', 'bool');
		Validators::assertField($config, 'trait', 'type');
		Validators::assertField($config, 'geolocationCallable', NULL | 'type');
	}

}
