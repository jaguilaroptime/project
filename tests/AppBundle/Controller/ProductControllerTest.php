<?php

namespace Tests\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class ProductControllerTest extends WebTestCase
{
    public function testList()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/product/');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertContains('Lista de Productos', $crawler->filter('.container h1')->text());
        $this->assertGreaterThan(0, $crawler->filter('h1')->count());
        $this->assertRegExp('/Lista de Productos/',$client->getResponse()->getContent());
        $this->assertTrue($client->getResponse()->isSuccessful());
        $this->assertEquals(
            Response::HTTP_OK,
            $client->getResponse()->getStatusCode()
        );

    }
}