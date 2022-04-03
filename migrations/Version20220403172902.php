<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220403172902 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE `order` ADD user_id INT DEFAULT NULL, ADD status SMALLINT NOT NULL, ADD sub_total DOUBLE PRECISION NOT NULL, ADD item_discount DOUBLE PRECISION NOT NULL, ADD tax DOUBLE PRECISION NOT NULL, ADD shipping DOUBLE PRECISION NOT NULL, ADD total DOUBLE PRECISION NOT NULL, ADD promo VARCHAR(50) DEFAULT NULL, ADD discount DOUBLE PRECISION NOT NULL, ADD grand_total DOUBLE PRECISION NOT NULL, ADD first_name VARCHAR(50) DEFAULT NULL, ADD middle_name VARCHAR(50) DEFAULT NULL, ADD last_name VARCHAR(50) DEFAULT NULL, ADD mobile VARCHAR(15) DEFAULT NULL, ADD email VARCHAR(50) DEFAULT NULL, ADD line1 VARCHAR(50) DEFAULT NULL, ADD line2 VARCHAR(50) DEFAULT NULL, ADD city VARCHAR(50) DEFAULT NULL, ADD province VARCHAR(50) DEFAULT NULL, ADD country VARCHAR(50) DEFAULT NULL, ADD created_at DATETIME NOT NULL, ADD updated_at DATETIME DEFAULT NULL, ADD content LONGTEXT DEFAULT NULL');
        $this->addSql('ALTER TABLE `order` ADD CONSTRAINT FK_F5299398A76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id)');
        $this->addSql('CREATE INDEX IDX_F5299398A76ED395 ON `order` (user_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE `order` DROP FOREIGN KEY FK_F5299398A76ED395');
        $this->addSql('DROP INDEX IDX_F5299398A76ED395 ON `order`');
        $this->addSql('ALTER TABLE `order` DROP user_id, DROP status, DROP sub_total, DROP item_discount, DROP tax, DROP shipping, DROP total, DROP promo, DROP discount, DROP grand_total, DROP first_name, DROP middle_name, DROP last_name, DROP mobile, DROP email, DROP line1, DROP line2, DROP city, DROP province, DROP country, DROP created_at, DROP updated_at, DROP content');
    }
}
