<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241107154249 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE services (id INT NOT NULL, type SMALLINT NOT NULL, description VARCHAR(500) DEFAULT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE tariff_services (service_id INT NOT NULL, tariff_name VARCHAR(255) NOT NULL, PRIMARY KEY(service_id, tariff_name))');
        $this->addSql('CREATE INDEX IDX_FA11D5CAED5CA9E6 ON tariff_services (service_id)');
        $this->addSql('CREATE INDEX IDX_FA11D5CAF947C388 ON tariff_services (tariff_name)');
        $this->addSql('CREATE TABLE tariffs (name VARCHAR(255) NOT NULL, description VARCHAR(500) DEFAULT NULL, price NUMERIC(10, 2) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(name))');
        $this->addSql('CREATE UNIQUE INDEX name ON tariffs (name)');
        $this->addSql('CREATE TABLE user_addresses (address VARCHAR(255) NOT NULL, tariff_name VARCHAR(255) DEFAULT NULL, status VARCHAR(20) NOT NULL, balance NUMERIC(10, 2) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(address))');
        $this->addSql('CREATE INDEX IDX_6F2AF8F2F947C388 ON user_addresses (tariff_name)');
        $this->addSql('CREATE UNIQUE INDEX address ON user_addresses (address)');
        $this->addSql('CREATE TABLE users (id INT NOT NULL, username VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, phone VARCHAR(20) NOT NULL, email VARCHAR(255) NOT NULL, language VARCHAR(2) DEFAULT \'en\' NOT NULL, theme VARCHAR(50) DEFAULT NULL, device_id VARCHAR(36) DEFAULT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX email ON users (email)');
        $this->addSql('ALTER TABLE tariff_services ADD CONSTRAINT FK_FA11D5CAED5CA9E6 FOREIGN KEY (service_id) REFERENCES services (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE tariff_services ADD CONSTRAINT FK_FA11D5CAF947C388 FOREIGN KEY (tariff_name) REFERENCES tariffs (name) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE user_addresses ADD CONSTRAINT FK_6F2AF8F2F947C388 FOREIGN KEY (tariff_name) REFERENCES tariffs (name) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE tariff_services DROP CONSTRAINT FK_FA11D5CAED5CA9E6');
        $this->addSql('ALTER TABLE tariff_services DROP CONSTRAINT FK_FA11D5CAF947C388');
        $this->addSql('ALTER TABLE user_addresses DROP CONSTRAINT FK_6F2AF8F2F947C388');
        $this->addSql('DROP TABLE services');
        $this->addSql('DROP TABLE tariff_services');
        $this->addSql('DROP TABLE tariffs');
        $this->addSql('DROP TABLE user_addresses');
        $this->addSql('DROP TABLE users');
    }
}
