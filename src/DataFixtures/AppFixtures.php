<?php

namespace App\DataFixtures;

use App\Entity\Category;
use App\Entity\Contact;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $noms = ['Dupont', 'Leprince', 'Maestre', 'Querrien', 'Duverne '];
        $prenoms = ['Tom', 'Jerry', 'Matt', 'Stéphane', 'Marine'];
        $telephones = ['01111111', '02222222', '03333333', '04444444', '05555555'];
        $adresses = ['16 rue grande', '30 boulevard Lafayette', '23 rue rivot', '12 du grand boulevard', '4 rue Napoléon'];
        $villes = ['Voisenon', 'Melun', 'Cesson', 'Paris', 'Lille'];
        $ages = ['20', '30', '40', '50', '60'];

        $categoryNames = ['famille', 'amis', 'travaille'];
        $categories = [];

        for ($b = 0; 3 > $b; $b++) {
            $category = new Category();
            $category->setName($categoryNames[$b]);
            $manager->persist($category);
            $categories[] = $category;
        }
        $manager->flush();


            for ($a = 0; 5 > $a; $a++) {

                $contact = new Contact();
                $contact
                    ->setNom($noms[$a])
                    ->setPrenom($prenoms[$a])
                    ->setTelephone($telephones[$a])
                    ->setAdresse($adresses[$a])
                    ->setVille($villes[$a])
                    ->setAge($ages[$a])
                    ->setCategory($categories[rand(0,2)]);
            $manager->persist($contact);
            }

        $manager->flush();
    }


}
