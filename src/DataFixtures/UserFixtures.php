<?php
namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Faker\Factory;

class UserFixtures extends Fixture
{
    private UserPasswordHasherInterface $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');
        
        $grades = [
            'Professeur',
            'Maître de conférences',
            'Maîtresse de conférences',
            'PRAG',
            'PRCE',
            'CPJ',
            'Enseignant-chercheur contractuel',
            'Enseignant contractuel',
            'ATER',
            'DMCE',
            'Intervenant extérieur'
        ];
        
        $composantes = [
            'UFR ST',
            'UFR DEG',
            'UFR LLSH',
            'IUT',
            'Polytech',
            'ESPE'
        ];

        // Créer un utilisateur de test avec email connu
        $testUser = new User();
        $testUser->setNom('Dupont');
        $testUser->setPrenom('Jean');
        $testUser->setEmail('admin@example.com');
        $testUser->setGrade('Professeur');
        $testUser->setComposante('UFR ST');
        $testUser->setRoles(['ROLE_USER', 'ROLE_RESPONSABLE_FORMATION']);
        $hashedPassword = $this->passwordHasher->hashPassword($testUser, 'password');
        $testUser->setPassword($hashedPassword);
        $manager->persist($testUser);
        
        // Sauvegarder la référence pour l'utiliser dans les autres fixtures
        $this->addReference('user-0', $testUser);

        // Créer des utilisateurs avec des grades permettant d'être responsable de formation
        $gradesResponsables = ['Professeur', 'Maître de conférences', 'Maîtresse de conférences', 'PRAG'];
        
        for ($i = 1; $i <= 5; $i++) {
            $user = new User();
            $user->setNom($faker->lastName());
            $user->setPrenom($faker->firstName());
            $user->setEmail($faker->email());
            $user->setGrade($faker->randomElement($gradesResponsables));
            $user->setComposante($faker->randomElement($composantes));
            $user->setRoles(['ROLE_USER', 'ROLE_RESPONSABLE_FORMATION']);
            
            $hashedPassword = $this->passwordHasher->hashPassword($user, 'password');
            $user->setPassword($hashedPassword);
            
            $manager->persist($user);
            $this->addReference('user-' . $i, $user);
        }

        // Créer des enseignants qui peuvent être responsables de cours
        for ($i = 6; $i <= 15; $i++) {
            $user = new User();
            $user->setNom($faker->lastName());
            $user->setPrenom($faker->firstName());
            $user->setEmail($faker->email());
            $user->setGrade($faker->randomElement($grades));
            $user->setComposante($faker->randomElement($composantes));
            
            // Certains seront responsables de cours, d'autres juste enseignants
            if ($i <= 12) {
                $user->setRoles(['ROLE_USER', 'ROLE_RESPONSABLE_COURS', 'ROLE_ENSEIGNANT']);
            } else {
                $user->setRoles(['ROLE_USER', 'ROLE_ENSEIGNANT']);
            }
            
            $hashedPassword = $this->passwordHasher->hashPassword($user, 'password');
            $user->setPassword($hashedPassword);
            
            $manager->persist($user);
            $this->addReference('user-' . $i, $user);
        }

        $manager->flush();
    }
}