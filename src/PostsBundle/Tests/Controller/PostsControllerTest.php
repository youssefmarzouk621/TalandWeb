<?php

namespace PostsBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class PostsControllerTest extends WebTestCase
{
    public function testAddpost()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/AddPost');
    }

    public function testGetposts()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/GetPosts');
    }

    public function testUpdatepost()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/UpdatePost');
    }

    public function testDeletepost()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/DeletePost');
    }

}
