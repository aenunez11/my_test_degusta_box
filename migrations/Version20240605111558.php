<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240605111558 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE allocation (id INT AUTO_INCREMENT NOT NULL, portfolio_id INT NOT NULL, shares INT NOT NULL, INDEX IDX_5C44232AB96B5643 (portfolio_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE client (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `order` (id INT AUTO_INCREMENT NOT NULL, portfolio_id INT NOT NULL, type VARCHAR(255) NOT NULL, shares INT NOT NULL, created_at DATETIME NOT NULL, completed_at DATETIME DEFAULT NULL, INDEX IDX_F5299398B96B5643 (portfolio_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE portfolio (id INT AUTO_INCREMENT NOT NULL, client_id INT NOT NULL, INDEX IDX_A9ED106219EB6921 (client_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE allocation ADD CONSTRAINT FK_5C44232AB96B5643 FOREIGN KEY (portfolio_id) REFERENCES portfolio (id)');
        $this->addSql('ALTER TABLE `order` ADD CONSTRAINT FK_F5299398B96B5643 FOREIGN KEY (portfolio_id) REFERENCES portfolio (id)');
        $this->addSql('ALTER TABLE portfolio ADD CONSTRAINT FK_A9ED106219EB6921 FOREIGN KEY (client_id) REFERENCES client (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE allocation DROP FOREIGN KEY FK_5C44232AB96B5643');
        $this->addSql('ALTER TABLE `order` DROP FOREIGN KEY FK_F5299398B96B5643');
        $this->addSql('ALTER TABLE portfolio DROP FOREIGN KEY FK_A9ED106219EB6921');
        $this->addSql('DROP TABLE allocation');
        $this->addSql('DROP TABLE client');
        $this->addSql('DROP TABLE `order`');
        $this->addSql('DROP TABLE portfolio');
    }
}
