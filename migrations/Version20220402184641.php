<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220402184641 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE cart ADD status SMALLINT NOT NULL, ADD first_name VARCHAR(50) DEFAULT NULL, ADD middle_name VARCHAR(50) DEFAULT NULL, ADD last_name VARCHAR(50) DEFAULT NULL, ADD mobile VARCHAR(15) DEFAULT NULL, ADD email VARCHAR(50) DEFAULT NULL, ADD created_at DATETIME NOT NULL, ADD update_at DATETIME DEFAULT NULL, ADD content LONGTEXT DEFAULT NULL');
        $this->addSql('ALTER TABLE user ADD cart_id INT NOT NULL');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D6491AD5CDBF FOREIGN KEY (cart_id) REFERENCES cart (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D6491AD5CDBF ON user (cart_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE cart DROP status, DROP first_name, DROP middle_name, DROP last_name, DROP mobile, DROP email, DROP created_at, DROP update_at, DROP content');
        $this->addSql('ALTER TABLE `user` DROP FOREIGN KEY FK_8D93D6491AD5CDBF');
        $this->addSql('DROP INDEX UNIQ_8D93D6491AD5CDBF ON `user`');
        $this->addSql('ALTER TABLE `user` DROP cart_id');
    }
}
