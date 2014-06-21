<?php

/**
 * This file is part of Zenify
 * Copyright (c) 2012 Tomas Votruba (http://tomasvotruba.cz)
 */

namespace Zenify\DoctrineBehaviors\Entities\Attributes;


trait Translatable
{

	/**
	 * @param string
	 * @return mixed
	 */
	public function &__get($name)
	{
		if (property_exists($this, $name) == FALSE && method_exists($this, 'get' . ucfirst($name)) == FALSE) {
			$var = $this->proxyCurrentLocaleTranslation('get' . ucfirst($name));
			return $var;
		}

		return parent::__get($name);
	}


	/**
	 * @param string
	 * @param array
	 * @return mixed
	 */
	public function __call($method, $arguments)
	{
		if (strpos($method, 'get') === 0) {
			$name = lcfirst(substr($method, 3));
			if (property_exists($this, $name)) {
				return parent::__call($method, $arguments);
			}
		}

		return $this->proxyCurrentLocaleTranslation($method, $arguments);
	}

}
