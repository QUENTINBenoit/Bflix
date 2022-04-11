<?php

namespace App\Tests\Main;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class HommePageTest extends WebTestCase
{

    /**
     * Je teste que l'on a bien accès à la page d'accueil
     * quand on n’est pas connecté 
     *
     * @return void
     */
    public function testHommPage(): void
    {
        $client = static::createClient();
        // Je demande à accéder à la page d'accueil en GET
        $crawler = $client->request('GET', '/');
        // je vérifie si la page est bien accessible 
        $this->assertResponseIsSuccessful();

        $this->assertSelectorTextContains('h1', 'Séries TV et bien plus en illimité.');
    }
    /**
     * Méthode qui permet de tester le clic sur le bouton 'Se connecter"
     * me redirige bien vers la page de login ("/Login")
     *
     * @return void
     */
    public function testLogin()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/');

        // Je simule un clic sur le bouton "Se connecter"
        // Après le clic on atterri sur la page de login 
        $client->clickLink('Se connecter');
        // Je vérifie que la page que je consulte ( la page de login ) 
        // existe bien 
        $this->assertResponseIsSuccessful('/login');
    }

    /**
     * Méthode permettant de tester le clic sur le bouton 'Créer un compte"
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

    /**
     * Vérifictaion que la page d'accueil est accessible 
     * aux personnes connectées avec le texte 
     * de bien venue et le prénom de la personne connectée
     *
     * @return void
     */
    public function testHommPageConnected()
    {
        $client = static::createClient();
        // Je simule une connexion avec un nom utilisateur (email)
        $userRepository = static::getContainer()->get(UserRepository::class);
        $user = $userRepository->findOneByEmail('user@gmail.com');
        $client->loginUser($user);
        // Je teste l'accès à la page d'accueil en mode connecté
        $client->request('GET', '/');
        $this->assertResponseIsSuccessful();
        // Je vérifie la présence d'un texte de bienvenue 
        $this->assertSelectorTextContains('h2', 'Bienvenue ' . $user->getFirstname(), 'L\'assertion a échoué : le texte n\'existe pas');
    }
}
