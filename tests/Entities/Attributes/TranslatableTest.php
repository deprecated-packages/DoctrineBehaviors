<?php

namespace Zenify\DoctrineBehaviors\Tests\Entities\Source;

use Doctrine\Common\Collections\ArrayCollection;
use PHPUnit_Framework_TestCase;


class TranslatableTest extends PHPUnit_Framework_TestCase
{

	public function testGetMethod()
	{
		$category = new Category('Some name', TRUE);
		$this->assertSame('Some name', $category->getName());
	}


	public function testIsMethod()
	{
		$category = new Category('Some name', TRUE);
		$this->assertTrue($category->isActive());
	}


	public function testHasMethod()
	{
		$tagDoctrine = new Tag('Doctrine');
		$tagNette = new Tag('Nette');

		$category = new Category('Some name', TRUE);
		$category->addTag($tagDoctrine);
		$category->addTag($tagNette);

		$this->assertInstanceOf(ArrayCollection::class, $category->getTags());
		$this->assertSame(2, $category->getTags()->count());
		$this->assertTrue($category->hasTag($tagNette));
	}


	public function testShouldMethod()
	{
		$category = new Category('Some name', TRUE);
		$category->setShouldRenderSubcategories(TRUE);

		$this->assertTrue($category->shouldRenderSubcategories());
	}

}
