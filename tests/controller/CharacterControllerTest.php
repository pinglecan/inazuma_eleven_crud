<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class CharacterControllerTest extends WebTestCase
{
    public function testSomething(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h1', '');
    }

    public function testShow(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/characters');
        $this->assertCount(6, $crawler->filter('a'));

        $client->clickLink('Keep Reading')->eq(3);

        $this->assertPageTitleContains('Welcome!');
        $this->assertResponseIsSuccessful();

        $this->assertSelectorTextContains('h1', 'Byron Love');
        // $this->assertSelectorExists(' :contains("There are 5 characters")');
    }
    

    public function testCreate(): void
    {
        $client = static::createClient();
        $crawler->clickLink('Create New character')->eq(0);

        $client->submitForm('submit', [
            'character_form[title]' => 'Shawn Frost',
            'character_form[posision]' => 'MF',
            'character_form[gender]' => 'Femboy',
            'character_form[teams]' => 1,
            'character_form[image]' => dirname(__DIR__, 2).'/public/images/shawn.png',
        ]);

        $client->followRedirect();
        $this->assertSelectorExists('div:contains("There are 3 characters")');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h1', 'There are 3 characters');
    }

    public function testEdit(): void
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/characters/edit/2');

        $client->submitForm('submit', [
            'character_form[title]' => 'aiden frost',
            'character_form[posision]' => 'FW',
            'character_form[gender]' => 'male',
            'character_form[teams]' => 2,
            'character_form[image]' => dirname(__DIR__, 2).'/public/images/aiden.png',
        ]);
        $this->assertResponseRedirects();
        $crawler= $client->followRedirect();


        $this->assertResponseIsSuccessful();
        // file_put_contents('test.html' , $crawler->html());

        $this->assertSelectorTextContains('h1', 'There are 2 characters');
    }

    public function testDelete(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', 'character/delete/3');

        $crawler= $client->followRedirect();

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('a', 'Characters');
    }
}
// 'GET', '/'