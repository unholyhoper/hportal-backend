<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210707124700 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE disease_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE medical_folder_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE rendez_vous_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE disease (id INT NOT NULL, name VARCHAR(255) DEFAULT NULL, description VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE medical_folder (id INT NOT NULL, owner_id INT DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_87FCBE627E3C61F9 ON medical_folder (owner_id)');
        $this->addSql('CREATE TABLE rendez_vous (id INT NOT NULL, doctor_id INT DEFAULT NULL, patient_id INT DEFAULT NULL, date DATE DEFAULT NULL, priority VARCHAR(255) DEFAULT NULL, status VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_65E8AA0A87F4FB17 ON rendez_vous (doctor_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_65E8AA0A6B899279 ON rendez_vous (patient_id)');
        $this->addSql('ALTER TABLE medical_folder ADD CONSTRAINT FK_87FCBE627E3C61F9 FOREIGN KEY (owner_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE rendez_vous ADD CONSTRAINT FK_65E8AA0A87F4FB17 FOREIGN KEY (doctor_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE rendez_vous ADD CONSTRAINT FK_65E8AA0A6B899279 FOREIGN KEY (patient_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE medecine ADD diseases_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE medecine ADD CONSTRAINT FK_9DC6C78CE672F970 FOREIGN KEY (diseases_id) REFERENCES disease (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_9DC6C78CE672F970 ON medecine (diseases_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE medecine DROP CONSTRAINT FK_9DC6C78CE672F970');
        $this->addSql('DROP SEQUENCE disease_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE medical_folder_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE rendez_vous_id_seq CASCADE');
        $this->addSql('DROP TABLE disease');
        $this->addSql('DROP TABLE medical_folder');
        $this->addSql('DROP TABLE rendez_vous');
        $this->addSql('DROP INDEX IDX_9DC6C78CE672F970');
        $this->addSql('ALTER TABLE medecine DROP diseases_id');
    }
}
