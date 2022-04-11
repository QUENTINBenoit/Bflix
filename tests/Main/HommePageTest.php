<?php

namespace App\Tests\Main;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class HommePageTest extends WebTestCase
{

    /**
     * Je test que l'on a bien accèes kà la page d'accueil
     * quand on est pas connecté 
     *
     * @return void
     */
    public function testHommPage(): void
    {

        $client = static::createClient();
        // Je demmande à accéder à la page d'acceuil en GET
        $crawler = $client->request('GET', '/');
        // On vérifie si la page est bine accessible 
        $this->assertResponseIsSuccessful();

        $this->assertSelectorTextContains('h1', 'Séries TV et bien plus en illimité.');
    }
    /**
     * Methode permettant de test le clic sur le boutton 'Se connecter"
     * me redirige bien vers la page de login ("/Login")
     *
     * @return void
     */
    public function testLogin()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/');

        // Je simule un clic sur le boutton "Se connecteré"
        // Après le clic on atteri sur la page de login 
        $client->clickLink('Se connecter');
        // Je vérifie que la page que je consulte ( lapage de login ) 
        // existe bien 
        $this->assertResponseIsSuccessful('/login');
    }

    /**
     * Methode permettant de tester le clic sur le boutton 'Créer un compte"
     * me redirige bien vers la page de register ("/register")
     *
     * @return void
     */
    public function testRegister()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/');

        $client->clickLink('Créer un compte');

        $this->assertResponseIsSuccessful('/register');
    }
}
