<?php

/**
 * This file is part of Zenify
 * Copyright (c) 2012 Tomas Votruba (http://tomasvotruba.cz)
 */

namespace Zenify\DoctrineBehaviors\DI;



trait TClassAnalyzer
{

	/**
	 * @return \Nette\DI\ServiceDefinition
	 */
	private function getClassAnalyzer()
	{
		$builder = $this->getContainerBuilder();

		if ($builder->hasDefinition('knp.classAnalyzer')) {
			return $builder->getDefinition('knp.classAnalyzer');
		}

		return $builder->addDefinition('knp.classAnalyzer')
			->setClass('Knp\DoctrineBehaviors\Reflection\ClassAnalyzer');
	}

}
