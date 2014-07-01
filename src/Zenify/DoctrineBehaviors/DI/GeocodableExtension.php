<?php

/**
 * This file is part of Zenify
 * Copyright (c) 2012 Tomas Votruba (http://tomasvotruba.cz)
 */

namespace Zenify\DoctrineBehaviors\DI;

use Kdyby;
use Nette\DI\CompilerExtension;


class GeocodableExtension extends CompilerExtension
{
	use TClassAnalyzer;

	/** @var [] */
	protected $default = [
		'isRecursive' => TRUE,
		'trait' => 'Knp\DoctrineBehaviors\Model\Geocodable\Geocodable',
		'geolocationCallable' => NULL
	];


	public function loadConfiguration()
	{
		$config = $this->getConfig($this->default);
		$builder = $this->getContainerBuilder();

		$builder->addDefinition($this->prefix('listener'))
			->setClass('Knp\DoctrineBehaviors\ORM\Geocodable\GeocodableListener', [
				'@' . $this->getClassAnalyzer()->getClass(),
				$config['isRecursive'],
				$config['trait'],
				$config['geolocationCallable']
			])
			->setAutowired(FALSE)
			->addTag(Kdyby\Events\DI\EventsExtension::TAG_SUBSCRIBER);
	}

}
