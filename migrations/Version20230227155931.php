<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230227155931 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE order_products ADD hidden TINYINT(1) NOT NULL, CHANGE total_price total_price NUMERIC(10, 4) NOT NULL');
        $this->addSql('ALTER TABLE orders ADD hidden TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE products ADD hidden TINYINT(1) NOT NULL, CHANGE price price NUMERIC(10, 4) NOT NULL');
        $this->addSql('ALTER TABLE restaurant ADD hidden TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE `table` ADD hidden TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE user ADD hidden TINYINT(1) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE `table` DROP hidden');
        $this->addSql('ALTER TABLE order_products DROP hidden, CHANGE total_price total_price INT NOT NULL');
        $this->addSql('ALTER TABLE orders DROP hidden');
        $this->addSql('ALTER TABLE `user` DROP hidden');
        $this->addSql('ALTER TABLE restaurant DROP hidden');
        $this->addSql('ALTER TABLE products DROP hidden, CHANGE price price INT NOT NULL');
    }
}
