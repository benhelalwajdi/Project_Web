<?php

namespace Loisirs\LoisirsBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class BonplanControllerTest extends WebTestCase
{
    public function testAjoutbonplan()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/AjoutBonplan');
    }

    public function testAffichebonplan()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/AfficheBonplan');
    }

}
