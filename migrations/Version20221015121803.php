<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221015121803 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE drivers (id INT AUTO_INCREMENT NOT NULL, last_name VARCHAR(255) NOT NULL, firts_name VARCHAR(255) NOT NULL, ssd VARCHAR(255) NOT NULL, dob DATE NOT NULL, address VARCHAR(255) NOT NULL, city VARCHAR(255) NOT NULL, zip VARCHAR(255) NOT NULL, phone BIGINT NOT NULL, active TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE route (id INT AUTO_INCREMENT NOT NULL, driver_id INT DEFAULT NULL, vehicle_id INT DEFAULT NULL, description LONGTEXT NOT NULL, active TINYINT(1) NOT NULL, INDEX IDX_2C42079C3423909 (driver_id), INDEX IDX_2C42079545317D1 (vehicle_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE schedules (id INT AUTO_INCREMENT NOT NULL, route_id INT DEFAULT NULL, week_num INT NOT NULL, fromm DATETIME NOT NULL, too DATETIME NOT NULL, active TINYINT(1) NOT NULL, INDEX IDX_313BDC8E34ECB4E6 (route_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE vehicles (id INT AUTO_INCREMENT NOT NULL, description LONGTEXT NOT NULL, year INT NOT NULL, make INT NOT NULL, capacity INT NOT NULL, active TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE route ADD CONSTRAINT FK_2C42079C3423909 FOREIGN KEY (driver_id) REFERENCES drivers (id)');
        $this->addSql('ALTER TABLE route ADD CONSTRAINT FK_2C42079545317D1 FOREIGN KEY (vehicle_id) REFERENCES vehicles (id)');
        $this->addSql('ALTER TABLE schedules ADD CONSTRAINT FK_313BDC8E34ECB4E6 FOREIGN KEY (route_id) REFERENCES route (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE route DROP FOREIGN KEY FK_2C42079C3423909');
        $this->addSql('ALTER TABLE route DROP FOREIGN KEY FK_2C42079545317D1');
        $this->addSql('ALTER TABLE schedules DROP FOREIGN KEY FK_313BDC8E34ECB4E6');
        $this->addSql('DROP TABLE drivers');
        $this->addSql('DROP TABLE route');
        $this->addSql('DROP TABLE schedules');
        $this->addSql('DROP TABLE vehicles');
    }
}
