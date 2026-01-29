<?php
namespace App\DataFixtures;

use App\Entity\Formation;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class FormationFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');
        
        $niveaux = ['Licence', 'Master', 'Doctorat'];
        $intitules = ['Informatique', 'Mathématiques', 'Physique', 'Chimie'];
        $parcours = ['MIAGE', 'Classique', 'Recherche', 'Professionnel'];
        
        for ($i = 0; $i < 10; $i++) {
            $formation = new Formation();
            $formation->setNiveau($faker->randomElement($niveaux));
            $formation->setIntitule($faker->randomElement($intitules));
            $formation->setParcours($faker->randomElement($parcours));
            
            $manager->persist($formation);
        }
        
        $manager->flush();
    }
}