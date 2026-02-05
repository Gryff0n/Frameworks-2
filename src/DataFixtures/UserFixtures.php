<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    private UserPasswordHasherInterface $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }

    public function load(ObjectManager $manager): void
    {
        // ============================================
        // RESPONSABLES DE FORMATION (users 0-5)
        // ============================================
        
        $formationResponsables = [
            ['nom' => 'Dubois', 'prenom' => 'Marie', 'email' => 'marie.dubois@univ.fr', 'grade' => 'Professeur', 'composante' => 'UFR ST'],
            ['nom' => 'Martin', 'prenom' => 'Pierre', 'email' => 'pierre.martin@univ.fr', 'grade' => 'Professeur', 'composante' => 'UFR DEG'],
            ['nom' => 'Bernard', 'prenom' => 'Sophie', 'email' => 'sophie.bernard@univ.fr', 'grade' => 'Maître de conférences', 'composante' => 'UFR LLSH'],
            ['nom' => 'Petit', 'prenom' => 'Thomas', 'email' => 'thomas.petit@univ.fr', 'grade' => 'Maîtresse de conférences', 'composante' => 'IUT'],
            ['nom' => 'Robert', 'prenom' => 'Claire', 'email' => 'claire.robert@univ.fr', 'grade' => 'PRAG', 'composante' => 'Polytech'],
            ['nom' => 'Richard', 'prenom' => 'Lucas', 'email' => 'lucas.richard@univ.fr', 'grade' => 'Professeur', 'composante' => 'UFR ST'],
        ];

        foreach ($formationResponsables as $index => $data) {
            $user = new User();
            $user->setNom($data['nom']);
            $user->setPrenom($data['prenom']);
            $user->setEmail($data['email']);
            $user->setGrade($data['grade']);
            $user->setComposante($data['composante']);
            $user->setRoles(['ROLE_USER', 'ROLE_RESPONSABLE_FORMATION']);
            
            $hashedPassword = $this->passwordHasher->hashPassword($user, 'password');
            $user->setPassword($hashedPassword);
            
            $manager->persist($user);
            $this->addReference('user-' . $index, $user);
        }

        // ============================================
        // RESPONSABLES DE COURS (users 6-12)
        // ============================================
        
        $coursResponsables = [
            ['nom' => 'Durand', 'prenom' => 'Jean', 'email' => 'jean.durand@univ.fr', 'grade' => 'Maître de conférences', 'composante' => 'UFR ST'],
            ['nom' => 'Moreau', 'prenom' => 'Julie', 'email' => 'julie.moreau@univ.fr', 'grade' => 'PRAG', 'composante' => 'UFR ST'],
            ['nom' => 'Simon', 'prenom' => 'Alexandre', 'email' => 'alexandre.simon@univ.fr', 'grade' => 'Maîtresse de conférences', 'composante' => 'IUT'],
            ['nom' => 'Laurent', 'prenom' => 'Emma', 'email' => 'emma.laurent@univ.fr', 'grade' => 'PRCE', 'composante' => 'UFR DEG'],
            ['nom' => 'Lefevre', 'prenom' => 'Nicolas', 'email' => 'nicolas.lefevre@univ.fr', 'grade' => 'Enseignant-chercheur contractuel', 'composante' => 'Polytech'],
            ['nom' => 'Michel', 'prenom' => 'Camille', 'email' => 'camille.michel@univ.fr', 'grade' => 'ATER', 'composante' => 'UFR ST'],
            ['nom' => 'Garcia', 'prenom' => 'Hugo', 'email' => 'hugo.garcia@univ.fr', 'grade' => 'Maître de conférences', 'composante' => 'UFR LLSH'],
        ];

        foreach ($coursResponsables as $index => $data) {
            $user = new User();
            $user->setNom($data['nom']);
            $user->setPrenom($data['prenom']);
            $user->setEmail($data['email']);
            $user->setGrade($data['grade']);
            $user->setComposante($data['composante']);
            $user->setRoles(['ROLE_USER', 'ROLE_RESPONSABLE_COURS', 'ROLE_ENSEIGNANT']);
            
            $hashedPassword = $this->passwordHasher->hashPassword($user, 'password');
            $user->setPassword($hashedPassword);
            
            $manager->persist($user);
            $this->addReference('user-' . (6 + $index), $user);
        }

        // ============================================
        // ENSEIGNANTS SIMPLES (users 13-15)
        // ============================================
        
        $enseignants = [
            ['nom' => 'Roux', 'prenom' => 'Léa', 'email' => 'lea.roux@univ.fr', 'grade' => 'Enseignant contractuel', 'composante' => 'UFR ST'],
            ['nom' => 'David', 'prenom' => 'Louis', 'email' => 'louis.david@univ.fr', 'grade' => 'DMCE', 'composante' => 'IUT'],
            ['nom' => 'Bertrand', 'prenom' => 'Chloé', 'email' => 'chloe.bertrand@univ.fr', 'grade' => 'Intervenant extérieur', 'composante' => 'Polytech'],
        ];

        foreach ($enseignants as $index => $data) {
            $user = new User();
            $user->setNom($data['nom']);
            $user->setPrenom($data['prenom']);
            $user->setEmail($data['email']);
            $user->setGrade($data['grade']);
            $user->setComposante($data['composante']);
            $user->setRoles(['ROLE_USER', 'ROLE_ENSEIGNANT']);
            
            $hashedPassword = $this->passwordHasher->hashPassword($user, 'password');
            $user->setPassword($hashedPassword);
            
            $manager->persist($user);
            $this->addReference('user-' . (13 + $index), $user);
        }

        $manager->flush();
    }
}