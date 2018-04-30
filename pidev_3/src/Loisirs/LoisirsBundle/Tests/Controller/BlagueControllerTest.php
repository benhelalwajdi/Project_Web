<?php

namespace Loisirs\LoisirsBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class BlagueControllerTest extends WebTestCase
{
    public function testAjoutblague()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/AjoutBlague');
    }

    public function testAfficheblague()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/AfficheBlague');
    }

}
