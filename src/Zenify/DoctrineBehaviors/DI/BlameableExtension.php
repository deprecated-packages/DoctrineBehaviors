<?php

/**
 * This file is part of Zenify
 * Copyright (c) 2012 Tomas Votruba (http://tomasvotruba.cz)
 */

namespace Zenify\DoctrineBehaviors\DI;

use Nette\DI\CompilerExtension;
use Kdyby;


class BlameableExtension extends CompilerExtension
{
	use TClassAnalyzer;

	/** @var [] */
	protected $default = [
		'isRecursive' => TRUE,
		'trait' => 'Knp\DoctrineBehaviors\Model\Blameable\Blameable',
		'userCallable' => 'Knp\DoctrineBehaviors\ORM\Blameable\UserCallable',
		'userEntity' => NULL
	];


	public function loadConfiguration()
	{
		$config = $this->getConfig($this->default);
		$builder = $this->getContainerBuilder();

		$builder->addDefinition($this->prefix('listener'))
			->setClass('Knp\DoctrineBehaviors\ORM\Blameable\BlameableListener', [
				'@' . $this->getClassAnalyzer()->getClass(),
				$config['isRecursive'],
				$config['trait'],
				$config['userCallable'],
				$config['userEntity']
			])
			->setAutowired(FALSE)
			->addTag(Kdyby\Events\DI\EventsExtension::TAG_SUBSCRIBER);
	}

}
