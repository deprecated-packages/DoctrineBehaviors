<?php

/**
 * This file is part of Zenify
 * Copyright (c) 2012 Tomas Votruba (http://tomasvotruba.cz)
 */

namespace Zenify\DoctrineBehaviors\DI;

use Kdyby;
use Nette;
use Nette\Utils\AssertionException;
use Nette\Utils\Validators;


class TranslatableExtension extends BehaviorExtension
{
	/** @var array */
	protected $default = [
		'isRecursive' => TRUE,
		'currentLocaleCallable' => NULL,
		'translatableTrait' => 'Knp\DoctrineBehaviors\Model\Translatable\Translatable',
		'translationTrait' => 'Knp\DoctrineBehaviors\Model\Translatable\Translation',
		'translatableFetchMode' => 'LAZY',
		'translationFetchMode' => 'LAZY',
	];


	public function loadConfiguration()
	{
		$config = $this->getConfig($this->default);
		$this->validateConfig($config);
		$builder = $this->getContainerBuilder();

		$builder->addDefinition($this->prefix('listener'))
			->setClass('Knp\DoctrineBehaviors\ORM\Translatable\TranslatableListener', [
				'@' . $this->getClassAnalyzer()->getClass(),
				$config['isRecursive'],
				$config['currentLocaleCallable'],
				$config['translatableTrait'],
				$config['translationTrait'],
				$config['translatableFetchMode'],
				$config['translationFetchMode']
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
		Validators::assertField($config, 'currentLocaleCallable', NULL | 'array');
		Validators::assertField($config, 'translatableTrait', 'type');
		Validators::assertField($config, 'translationTrait', 'type');
		Validators::assertField($config, 'translatableFetchMode', 'string');
		Validators::assertField($config, 'translationFetchMode', 'string');
	}

}
