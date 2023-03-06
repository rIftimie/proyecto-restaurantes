<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230303162345 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE order_products ADD hidden TINYINT(1) NOT NULL, CHANGE total_price total_price NUMERIC(10, 4) NOT NULL');
        $this->addSql('ALTER TABLE orders ADD table_order_id INT NOT NULL, ADD hidden TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE orders ADD CONSTRAINT FK_E52FFDEE1D2243E8 FOREIGN KEY (table_order_id) REFERENCES `table` (id)');
        $this->addSql('CREATE INDEX IDX_E52FFDEE1D2243E8 ON orders (table_order_id)');
        $this->addSql('ALTER TABLE products ADD hidden TINYINT(1) NOT NULL, ADD price NUMERIC(10, 4) NOT NULL, DROP stock');
        $this->addSql('ALTER TABLE restaurant ADD hidden TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE `table` ADD hidden TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE user ADD hidden TINYINT(1) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE orders DROP FOREIGN KEY FK_E52FFDEE1D2243E8');
        $this->addSql('DROP INDEX IDX_E52FFDEE1D2243E8 ON orders');
        $this->addSql('ALTER TABLE orders DROP table_order_id, DROP hidden');
        $this->addSql('ALTER TABLE order_products DROP hidden, CHANGE total_price total_price INT NOT NULL');
        $this->addSql('ALTER TABLE products ADD stock INT NOT NULL, DROP hidden, DROP price');
        $this->addSql('ALTER TABLE restaurant DROP hidden');
        $this->addSql('ALTER TABLE `table` DROP hidden');
        $this->addSql('ALTER TABLE `user` DROP hidden');
    }
}
