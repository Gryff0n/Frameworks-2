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
            [1, 'Programmation Impérative', '## Introduction à la programmation en C

Ce cours vous initie aux **concepts fondamentaux** de la programmation.

### Objectifs :
- Maîtriser la syntaxe du langage C
- Comprendre la gestion de la *mémoire*
- Utiliser les **pointeurs** et tableaux

> Un cours essentiel pour débuter en informatique !', 6, 20, 20, 20],

            [1, 'Mathématiques Discrètes', '## Logique, ensembles et combinatoire

### Contenu du cours :
1. **Logique propositionnelle** et prédicats
2. Théorie des ensembles
3. Relations et fonctions
4. Combinatoire et dénombrement

Ce cours est la *base mathématique* de l\'informatique.', 6, 24, 24, 0],

            [1, 'Architecture des Ordinateurs', '## Fonctionnement interne des ordinateurs

Découvrez comment fonctionne un ordinateur de l\'intérieur !

### Programme :
- Représentation binaire des données
- Architecture Von Neumann
- **Processeur** : ALU, registres, pipeline
- Mémoire cache et hiérarchie mémoire
- Assembleur et instructions machine', 5, 18, 18, 12],

            [2, 'Programmation Orientée Objet', '## POO en Java

### Concepts clés :
- **Classes** et objets
- Encapsulation
- Héritage et polymorphisme
- Interfaces et classes abstraites

Exemple de code :
`````java
public class Etudiant {
    private String nom;
    
    public Etudiant(String nom) {
        this.nom = nom;
    }
}
`````

> La POO est un *paradigme incontournable* en développement moderne.', 6, 20, 20, 20],

            [2, 'Bases de Données', '## Conception et requêtes SQL

### Au programme :
1. Modèle **relationnel**
2. Conception de schémas (formes normales)
3. Langage SQL :
   - SELECT, INSERT, UPDATE, DELETE
   - JOINtures
   - Sous-requêtes
4. Transactions et contraintes

Exemple de requête :
`````sql
SELECT nom, prenom 
FROM etudiants 
WHERE semestre = 2;
````', 6, 18, 18, 18],

            [3, 'Algorithmique Avancée', '## Complexité et structures de données

### Thèmes abordés :
- Analyse de **complexité** (notation Big O)
- Structures de données avancées :
  - Arbres (AVL, Rouge-Noir)
  - Graphes
  - Tables de hachage
- Algorithmes de tri et recherche
- Programmation dynamique

> *Optimisez vos programmes* pour de meilleures performances !', 6, 24, 24, 12],

            [3, 'Développement Web', '## HTML, CSS, JavaScript

### Technologies web modernes :
- **HTML5** : structure sémantique
- **CSS3** : mise en page, animations, responsive design
- **JavaScript** : interactivité et manipulation du DOM

#### Frameworks abordés :
- Bootstrap pour le CSS
- Introduction à React/Vue.js

Créez des sites web *dynamiques* et *attractifs* !', 5, 15, 15, 20],

            [4, 'Réseaux', '## Protocoles et architecture réseau

### Modèle OSI et TCP/IP :
1. Couche physique
2. Couche liaison
3. Couche réseau (IP, routage)
4. Couche transport (TCP, UDP)
5. Couche application (HTTP, DNS, FTP)

**Concepts clés :**
- Adressage IP et sous-réseaux
- Routage et commutation
- Sécurité réseau (pare-feu, VPN)

> Comprendre *comment internet fonctionne* réellement.', 5, 20, 20, 10],

            [4, 'Systèmes d\'Exploitation', '## Linux et gestion des processus

### Programme détaillé :
- Introduction aux **systèmes Unix/Linux**
- Gestion des processus et threads
- Système de fichiers
- Mémoire virtuelle
- Synchronisation et communications inter-processus

Commandes essentielles :
```bash
ps aux | grep java
kill -9 1234
chmod 755 script.sh
```

*Maîtrisez l\'environnement de développement professionnel !*', 6, 20, 20, 15],

            [5, 'Intelligence Artificielle', '## Machine Learning et IA

### Domaines couverts :
1. **Apprentissage supervisé** :
   - Régression linéaire
   - Classification (SVM, arbres de décision)
2. **Apprentissage non supervisé** :
   - Clustering (K-means)
   - Réduction de dimensionnalité
3. Réseaux de neurones et Deep Learning
4. Traitement du langage naturel

> L\'IA révolutionne *tous les secteurs* de l\'industrie !

**Outils utilisés :** Python, TensorFlow, scikit-learn', 6, 24, 12, 12],
        ];

        foreach ($coursData as $data) {
            $cours = new Cours();
            $cours->setSemestre($data[0]);
            $cours->setNom($data[1]);
            $cours->setDescription($data[2]);
            $cours->setEcts($data[3]);
            $cours->setHeureCM($data[4]);     
            $cours->setHeureTD($data[5]);   
            $cours->setHeureTP($data[6]);      
            
            $manager->persist($cours);
        }

        $manager->flush();
    }
}
