<?php

/**
 * This file is part of Zenify
 * Copyright (c) 2012 Tomas Votruba (http://tomasvotruba.cz)
 */

namespace Zenify\DoctrineBehaviors\Loggable;


interface Logger
{

	/**
	 * @param mixed $message
	 */
	public function process($message);

}
