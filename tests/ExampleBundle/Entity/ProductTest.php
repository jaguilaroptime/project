<?php

namespace ExampleBundle\Tests\Entity;

use ExampleBundle\Entity\Product;
use ExampleBundle\Entity\ProductCategory;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ProductTest extends WebTestCase
{
    public function testName(){

        $product = new Product();

        $this->assertNull($product->getName(), 'El nombre deberia ser null');
        $this->assertEmpty($product->getName());

        $product->setName('Producto de Test');

        $this->assertEquals('Producto de Test',$product->getName());
        $this->assertSame('Producto de Test',$product->getName());

        $this->assertContains('Test', $product->getName());

    }

    public function testDescription(){

        $product = new Product();

        $this->assertNull($product->getDescription(), 'La descripcion deberia ser null');

        $text = "Contiene informacion del producto de forma detallada";
        $product->setDescription($text);

        $this->assertSame($text, $product->getDescription());
        $this->assertContains('producto', $product->getDescription());
    }

    public function testCategory(){
        $product = new Product();
        $this->assertNull($product->getCategory(), 'La categoria deberia ser null');

        $category  = new ProductCategory();

        $product->setCategory($category);
        $this->assertSame($category, $product->getCategory());
        $this->assertNotNull($product->getCategory());
    }

    public function testGetValidationGroups_CaseNotPremiunInArray(){
        $product = new Product();
        $category  = new ProductCategory();

        $category->setPremiun(true);

        $product->setCategory($category);

        $groups = $product->getValidationGroup();
        print_r($groups);

        $this->assertCount(1,$groups);
        $this->assertContains('Default', $groups);
    }

    public function testGetValidationGroups_CaseHasPremiumInArray()
    {
        $product = new Product();

        $groups = $product->getValidationGroup();

        $this->assertCount(2, $groups);
        $this->assertContains('Default', $groups);
        $this->assertContains('Premiun', $groups);
        /*$this->assertArrayHasKey('user', $groups);
        $this->assertContains('Hola', $groups['user']);*/

        $category = new ProductCategory();

        $category->setPremiun(false);
        $product->setCategory($category);

        $this->assertCount(2, $groups);
        $this->assertContains('Default', $groups);
        $this->assertContains('Premiun', $groups);
    }
}