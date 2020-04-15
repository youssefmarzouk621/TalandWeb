<?php

namespace ProductBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ProductControllerTest extends WebTestCase
{
    public function testGetproducts()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/getProducts');
    }

}
