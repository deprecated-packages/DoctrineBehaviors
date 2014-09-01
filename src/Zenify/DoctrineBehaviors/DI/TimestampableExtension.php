<?php

/**
 * This file is part of Zenify
 * Copyright (c) 2012 Tomas Votruba (http://tomasvotruba.cz)
 */

namespace Zenify\DoctrineBehaviors\DI;

use Kdyby;
use Nette\Utils\AssertionException;
use Nette\Utils\Validators;


class TimestampableExtension extends BehaviorExtension
{
	/** @var array */
	protected $default = [
		'isRecursive' => TRUE,
		'trait' => 'Knp\DoctrineBehaviors\Model\Timestampable\Timestampable'
	];


	public function loadConfiguration()
	{
		$config = $this->getConfig($this->default);
		$this->validateConfig($config);
		$builder = $this->getContainerBuilder();

		$builder->addDefinition($this->prefix('listener'))
			->setClass('Knp\DoctrineBehaviors\ORM\Timestampable\TimestampableListener', [
				'@' . $this->getClassAnalyzer()->getClass(),
				$config['isRecursive'],
				$config['trait']
			])
			->setAutowired(FALSE)
			->addTag(Kdyby\Events\DI\EventsExtension::TAG_SUBSCRIBER);
	}


	/**
	 * @param array $config
	 * @throws AssertionException
	 */
	private function validateConfig($config)
	{
		Validators::assertField($config, 'isRecursive', 'bool');
		Validators::assertField($config, 'trait', 'type');
	}

}
