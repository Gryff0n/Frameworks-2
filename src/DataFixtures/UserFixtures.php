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
        $hashedPassword = $this->passwordHasher->hashPassword($testUser, 'password');
        $testUser->setPassword($hashedPassword);
        $manager->persist($testUser);

        for ($i = 0; $i < 10; $i++) {
            $user = new User();
            $user->setNom($faker->lastName());
            $user->setPrenom($faker->firstName());
            $user->setEmail($faker->email());
            $user->setGrade($faker->randomElement($grades));
            $user->setComposante($faker->randomElement($composantes));
            
            // Attribuer des rôles aléatoirement
            $rolesPossibles = [
                ['ROLE_USER'],
                ['ROLE_USER', 'ROLE_RESPONSABLE_FORMATION'],
                ['ROLE_USER', 'ROLE_RESPONSABLE_COURS'],
                ['ROLE_USER', 'ROLE_ENSEIGNANT'],
            ];
            $user->setRoles($faker->randomElement($rolesPossibles));
            
            $hashedPassword = $this->passwordHasher->hashPassword($user, 'password');
            $user->setPassword($hashedPassword);
            
            $manager->persist($user);
        }

        $manager->flush();
    }
}