<?php

namespace Zenify\DoctrineBehaviors\Tests;

use Nette\Configurator;
use Nette\DI\Container;


class ContainerFactory
{

	/**
	 * @return Container
	 */
	public function create()
	{
		$configurator = new Configurator;
		$configurator->setTempDirectory($this->createAndReturnTempDir());
		$configurator->addConfig(__DIR__ . '/config/default.neon');
		return $configurator->createContainer();
	}


	/**
	 * @return string
	 */
	private function createAndReturnTempDir()
	{
		$tempDir = __DIR__ . '/temp';
		@mkdir($tempDir, 0777, TRUE);
		return $tempDir;
	}

}
