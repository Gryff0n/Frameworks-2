<?php
namespace App\DataFixtures;

use App\Entity\Formation;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Faker\Factory;

class FormationFixtures extends Fixture implements DependentFixtureInterface
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
            
            // Assigner un responsable de formation (user-0 à user-5)
            $responsableIndex = $i % 6;
            $responsable = $this->getReference('user-' . $responsableIndex, User::class);
            $formation->setResponsable($responsable);
            
            $manager->persist($formation);
            $this->addReference('formation-' . $i, $formation);
        }
        
        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            UserFixtures::class,
        ];
    }
}