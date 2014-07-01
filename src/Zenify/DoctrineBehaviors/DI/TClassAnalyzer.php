<?php

/**
 * This file is part of Zenify
 * Copyright (c) 2012 Tomas Votruba (http://tomasvotruba.cz)
 */

namespace Zenify\DoctrineBehaviors\DI;

use Nette\DI\ContainerBuilder;
use Nette\DI\ContainerExtension;


trait TClassAnalyzer
{

	/**
	 * @return \Nette\DI\ServiceDefinition
	 */
	private function getClassAnalyzer()
	{
		/** @var ContainerExtension $this */
		/** @var ContainerBuilder $builder */
		$builder = $this->getContainerBuilder();

		if ($builder->hasDefinition('knp.classAnalyzer')) {
			return $builder->getDefinition('knp.classAnalyzer');
		}

		return $builder->addDefinition('knp.classAnalyzer')
			->setClass('Knp\DoctrineBehaviors\Reflection\ClassAnalyzer');
	}

}
