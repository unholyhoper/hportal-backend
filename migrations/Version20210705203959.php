<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210705203959 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE medecine_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE medecine (id INT NOT NULL, reference VARCHAR(255) DEFAULT NULL, manufacturer VARCHAR(255) DEFAULT NULL, quantity INT DEFAULT NULL, expiration_date DATE DEFAULT NULL, price DOUBLE PRECISION DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('ALTER TABLE "user" DROP gender');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE medecine_id_seq CASCADE');
        $this->addSql('DROP TABLE medecine');
        $this->addSql('ALTER TABLE "user" ADD gender VARCHAR(20) DEFAULT NULL');
    }
}
