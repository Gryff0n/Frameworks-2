<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260129160236 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE cours (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, semestre INTEGER NOT NULL, description CLOB NOT NULL, ects INTEGER NOT NULL, heure_cm INTEGER NOT NULL, heure_td INTEGER NOT NULL, heure_tp INTEGER NOT NULL, date_creation DATETIME NOT NULL, date_modification DATETIME NOT NULL)');
        $this->addSql('CREATE TABLE cours_formation (cours_id INTEGER NOT NULL, formation_id INTEGER NOT NULL, PRIMARY KEY (cours_id, formation_id), CONSTRAINT FK_B8E51B787ECF78B0 FOREIGN KEY (cours_id) REFERENCES cours (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_B8E51B785200282E FOREIGN KEY (formation_id) REFERENCES formation (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_B8E51B787ECF78B0 ON cours_formation (cours_id)');
        $this->addSql('CREATE INDEX IDX_B8E51B785200282E ON cours_formation (formation_id)');
        $this->addSql('CREATE TABLE formation (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, niveau VARCHAR(255) NOT NULL, intitule VARCHAR(255) NOT NULL, parcours VARCHAR(255) NOT NULL)');
        $this->addSql('CREATE TABLE messenger_messages (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, body CLOB NOT NULL, headers CLOB NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL)');
        $this->addSql('CREATE INDEX IDX_75EA56E0FB7336F0E3BD61CE16BA31DBBF396750 ON messenger_messages (queue_name, available_at, delivered_at, id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE cours');
        $this->addSql('DROP TABLE cours_formation');
        $this->addSql('DROP TABLE formation');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
