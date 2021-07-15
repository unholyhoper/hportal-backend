<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210714224522 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE material_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE material (id INT NOT NULL, name VARCHAR(255) DEFAULT NULL, type VARCHAR(255) DEFAULT NULL, quantity INT DEFAULT NULL, image BYTEA DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('DROP INDEX IDX_65E8AA0A6B899279');
        $this->addSql('DROP INDEX IDX_65E8AA0A87F4FB17');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_65E8AA0A87F4FB17 ON rendez_vous (doctor_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_65E8AA0A6B899279 ON rendez_vous (patient_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE material_id_seq CASCADE');
        $this->addSql('DROP TABLE material');
        $this->addSql('ALTER TABLE "user" ALTER enabled SET DEFAULT \'false\'');
        $this->addSql('DROP INDEX UNIQ_65E8AA0A87F4FB17');
        $this->addSql('DROP INDEX UNIQ_65E8AA0A6B899279');
        $this->addSql('CREATE INDEX IDX_65E8AA0A6B899279 ON rendez_vous (patient_id)');
        $this->addSql('CREATE INDEX IDX_65E8AA0A87F4FB17 ON rendez_vous (doctor_id)');
    }
}
