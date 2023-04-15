<?php

namespace App\DataFixtures;

use App\Entity\Hamster;
use App\Entity\Movie;
use App\Entity\Quote;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    private $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }

    public function load(ObjectManager $manager): void
    {
        // generate an array of movie entities with name and release date
        $movies = [
            ['name' => 'The Shawshank Redemption', 'releaseDate' => new \DateTime('1994-09-23'), 'rating' => 6.3],
            ['name' => 'The Godfather', 'releaseDate' => new \DateTime('1972-03-24'), 'rating' => 9.2],
            ['name' => 'The Godfather: Part II', 'releaseDate' => new \DateTime('1974-12-20'), 'rating' => 9.0],
            ['name' => 'The Dark Knight', 'releaseDate' => new \DateTime('2008-07-18'), 'rating' => 9.4],
        ];

        // create a list of quotes for above movies with character
        $quotes = [
            ['movie' => 'The Shawshank Redemption', 'character' => 'Andy Dufresne', 'quote' => 'Get busy living or get busy dying.'],
            ['movie' => 'The Shawshank Redemption', 'character' => 'Red', 'quote' => 'Hope is a good thing, maybe the best of things, and no good thing ever dies.'],
            ['movie' => 'The Shawshank Redemption', 'character' => 'Andy Dufresne', 'quote' => 'Remember Red, hope is a good thing, maybe the best of things, and no good thing ever dies.'],
            ['movie' => 'The Godfather', 'character' => 'Michael Corleone', 'quote' => 'I\'m gonna make him an offer he can\'t refuse.'],
            ['movie' => 'The Godfather', 'character' => 'Michael Corleone', 'quote' => 'Just when I thought I was out, they pull me back in.'],
            ['movie' => 'The Godfather', 'character' => 'Michael Corleone', 'quote' => 'Keep your friends close, but your enemies closer.'],
            ['movie' => 'The Godfather: Part II', 'character' => 'Michael Corleone', 'quote' => 'Just when I thought I was out, they pull me back in.'],
            ['movie' => 'The Godfather: Part II', 'character' => 'Michael Corleone', 'quote' => 'Keep your friends close, but your enemies closer.'],
            ['movie' => 'The Godfather: Part II', 'character' => 'Michael Corleone', 'quote' => 'I\'m gonna make him an offer he can\'t refuse.'],
            ['movie' => 'The Dark Knight', 'character' => 'The Joker', 'quote' => 'Why so serious?'],
            ['movie' => 'The Dark Knight', 'character' => 'The Joker', 'quote' => 'You either die a hero, or you live long enough to see yourself become the villain.'],
            ['movie' => 'The Dark Knight', 'character' => 'The Joker', 'quote' => 'Why so not serious?'],
        ];

        foreach ($movies as $movie) {
            $movieEntity = new Movie();
            $movieEntity->setName($movie['name']);
            $movieEntity->setReleaseDate($movie['releaseDate']);
            $movieEntity->setRating($movie['rating']);
            $manager->persist($movieEntity);
        }
        $manager->flush();

        foreach ($quotes as $quote) {
            $quoteEntity = new Quote();
            $quoteEntity->setCharacterName($quote['character']);
            $quoteEntity->setQuote($quote['quote']);
            $quoteEntity->setMovie($manager->getRepository(Movie::class)->findOneBy(['name' => $quote['movie']]));
            $manager->persist($quoteEntity);
        }

        //create default admin
        $admin = new User();
        $admin->setUsername('admin');
        $admin->setPassword($this->passwordHasher->hashPassword($admin, 'admin123!'));
        $admin->setRoles(['ROLE_ADMIN']);
        $manager->persist($admin);
        $manager->flush();
    }
}
