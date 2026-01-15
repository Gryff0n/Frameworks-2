<?php

namespace App\DataFixtures;

use App\Entity\Cours;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CoursFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $coursData = [
        [1, 'Programmation Impérative', 'Introduction à la programmation en C'],
        [1, 'Mathématiques Discrètes', 'Logique, ensembles et combinatoire'],
        [1, 'Architecture des Ordinateurs', 'Fonctionnement interne des ordinateurs'],
        [2, 'Programmation Orientée Objet', 'POO en Java'],
        [2, 'Bases de Données', 'Conception et requêtes SQL'],
        [3, 'Algorithmique Avancée', 'Complexité et structures de données'],
        [3, 'Développement Web', 'HTML, CSS, JavaScript'],
        [4, 'Réseaux', 'Protocoles et architecture réseau'],
        [4, 'Systèmes d\'Exploitation', 'Linux et gestion des processus'],
        [5, 'Intelligence Artificielle', 'Machine Learning et IA'],
        ];

        foreach ($coursData as $data) {
            $cours = new Cours();
            $cours->setSemestre($data[0]);
            $cours->setNom($data[1]);
            $cours->setDescription($data[2]);
            $manager->persist($cours);
        }

        $manager->flush();
    }
}