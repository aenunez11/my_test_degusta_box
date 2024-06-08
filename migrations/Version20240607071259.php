<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240607071259 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE orders (id INT AUTO_INCREMENT NOT NULL, portfolio_id INT NOT NULL, type VARCHAR(255) NOT NULL, allocation_id INT DEFAULT NULL, shares INT NOT NULL, created_at DATETIME NOT NULL, completed_at DATETIME DEFAULT NULL, INDEX IDX_E52FFDEEB96B5643 (portfolio_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE orders ADD CONSTRAINT FK_E52FFDEEB96B5643 FOREIGN KEY (portfolio_id) REFERENCES portfolio (id)');
        $this->addSql('ALTER TABLE `order` DROP FOREIGN KEY FK_F5299398B96B5643');
        $this->addSql('DROP TABLE `order`');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE `order` (id INT AUTO_INCREMENT NOT NULL, portfolio_id INT NOT NULL, type VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, shares INT NOT NULL, created_at DATETIME NOT NULL, completed_at DATETIME DEFAULT NULL, allocation_id INT DEFAULT NULL, INDEX IDX_F5299398B96B5643 (portfolio_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE `order` ADD CONSTRAINT FK_F5299398B96B5643 FOREIGN KEY (portfolio_id) REFERENCES portfolio (id)');
        $this->addSql('ALTER TABLE orders DROP FOREIGN KEY FK_E52FFDEEB96B5643');
        $this->addSql('DROP TABLE orders');
    }
}
