<?php

/** @var Composer\Autoload\ClassLoader $classLoader */
if (@ ! $classLoader = include __DIR__ . '/../../vendor/autoload.php') {
	echo 'Install Nette Tester using `composer update --dev`';
	exit(1);
}
$classLoader->addPsr4('ZenifyTests\\', __DIR__);


// configure environment
Tester\Environment::setup();
date_default_timezone_set('Europe/Prague');

define('TEMP_DIR', createAndReturnTempDir());


/** @return string */
function createAndReturnTempDir() {
	$tmpDir = __DIR__ . '/../tmp/' . (isset($_SERVER['argv']) ? md5(serialize($_SERVER['argv'])) : getmypid());
	Tester\Helpers::purge($tmpDir);
	return $tmpDir;
}

Tracy\Debugger::$logDirectory = TEMP_DIR;


$configurator = new Nette\Configurator;
$configurator->setTempDirectory(TEMP_DIR);
$configurator->addConfig(__DIR__ . '/config/default.neon');
return $configurator->createContainer();
