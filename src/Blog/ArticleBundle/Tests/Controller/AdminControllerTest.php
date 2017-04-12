<?php

namespace Blog\ArticleBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class AdminControllerTest extends WebTestCase
{
    public function testAddpost()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/admin/addpost');
    }

}
