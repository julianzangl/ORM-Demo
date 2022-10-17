<?php

namespace App\DataFixtures;

use App\Entity\Hamster;
use App\Entity\Movie;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // generate an array of movie entities with name and release date
        $movies = [
            ['name' => 'The Shawshank Redemption', 'releaseDate' => new \DateTime('1994-09-23')],
            ['name' => 'The Godfather', 'releaseDate' => new \DateTime('1972-03-24')],
            ['name' => 'The Godfather: Part II', 'releaseDate' => new \DateTime('1974-12-20')],
            ['name' => 'The Dark Knight', 'releaseDate' => new \DateTime('2008-07-18')],
            ['name' => '12 Angry', 'releaseDate' => new \DateTime('1957-04-10')],
            ['name' => "Schindler's List", 'releaseDate' => new \DateTime('1993-11-30')],
            ['name' => 'The Lord of the Rings: The Return of the King', 'releaseDate' => new \DateTime('2003-12-01')],
            ['name' => 'Pulp Fiction', 'releaseDate' => new \DateTime('1994-10-14')],
            ['name' => 'The Good, the Bad and the Ugly', 'releaseDate' => new \DateTime('1966-12-23')],
            ['name' => 'The Lord of the Rings: The Fellowship of the Ring', 'releaseDate' => new \DateTime('2001-12-19')],
        ];

        // create a list of quotes for above movies
        $quotes = [
            'The Shawshank Redemption' => [
                'Get busy living or get busy dying.',
                'Hope is a good thing, maybe the best of things, and no good thing ever dies.',
                'Fear can hold you prisoner. Hope can set you free.',
            ],
            'The Godfather' => [
                'I\'m gonna make him an offer he can\'t refuse.',
                'Keep your friends close, but your enemies closer.',
                'Just when I thought I was out, they pull me back in.',
            ],
            'The Godfather: Part II' => [
                'Just when I thought I was out, they pull me back in.',
                'I believe in America.',
                'It\'s not personal, Sonny. It\'s strictly business.',
            ],
            'The Dark Knight' => [
                'Why so serious?',
                'You either die a hero, or you live long enough to see yourself become the villain.',
                'Why do we fall? So we can learn to pick ourselves up.',
            ],
            '12 Angry' => [
                'I\'m gonna make him an offer he can\'t refuse.',
                'Keep your friends close, but your enemies closer.',
                'Just when I thought I was out, they pull me back in.',
            ],
            "Schindler's List" => [
                'I could have got more out. I could have got more. I don\'t know. If I\'d just... I could have got more.',
                'I could have got one more. If I\'d just... I could have got one more. I could have got one more.',
                'I could have got one more. If I\'d just... I could have got one more. I could have got one more.',
            ],
            'The Lord of the Rings: The Return of the King' => [
                'My friends, you bow to no one.',
                'Fly, you fools!',
                'The world is changed. I feel it in the water. I feel it in the earth. I smell it in the air.',
            ],
            'Pulp Fiction' => [
                'I\'m gonna make him an offer he can\'t refuse.',
                'Keep your friends close, but your enemies closer.',
                'Just when I thought I was out, they pull me back in.',
            ]
            ];


        foreach ($movies as $movie) {


            $movieEntity = new Movie();

            
            $movieEntity->setName($movie['name']);
            $movieEntity->setReleaseDate($movie['releaseDate']);
            $manager->persist($movieEntity);
        }


        $manager->flush();
    }
}
