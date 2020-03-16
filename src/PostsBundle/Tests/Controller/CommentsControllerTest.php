<?php

namespace PostsBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class CommentsControllerTest extends WebTestCase
{
    public function testAddcomment()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/AddComment');
    }

    public function testGetcomments()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/GetComments');
    }

    public function testDeletecomment()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/DeleteComment');
    }

    public function testUpdatecomment()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/UpdateComment');
    }

}
