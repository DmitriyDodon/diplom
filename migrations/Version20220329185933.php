<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220329185933 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE product ADD user_id INT DEFAULT NULL, ADD title VARCHAR(75) NOT NULL, ADD meta_title VARCHAR(100) DEFAULT NULL, ADD slug VARCHAR(100) NOT NULL, ADD summary VARCHAR(80) DEFAULT NULL, ADD type SMALLINT NOT NULL, ADD sky VARCHAR(100) NOT NULL, ADD price DOUBLE PRECISION NOT NULL, ADD discount DOUBLE PRECISION NOT NULL, ADD shop TINYINT(1) NOT NULL, ADD created_at DATETIME NOT NULL, ADD updated_at DATETIME DEFAULT NULL, ADD published_at DATETIME DEFAULT NULL, ADD starts_at DATETIME DEFAULT NULL, ADD ends_at DATETIME DEFAULT NULL, ADD content LONGTEXT DEFAULT NULL');
        $this->addSql('ALTER TABLE product ADD CONSTRAINT FK_D34A04ADA76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_D34A04AD989D9B62 ON product (slug)');
        $this->addSql('CREATE INDEX IDX_D34A04ADA76ED395 ON product (user_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE product DROP FOREIGN KEY FK_D34A04ADA76ED395');
        $this->addSql('DROP INDEX UNIQ_D34A04AD989D9B62 ON product');
        $this->addSql('DROP INDEX IDX_D34A04ADA76ED395 ON product');
        $this->addSql('ALTER TABLE product DROP user_id, DROP title, DROP meta_title, DROP slug, DROP summary, DROP type, DROP sky, DROP price, DROP discount, DROP shop, DROP created_at, DROP updated_at, DROP published_at, DROP starts_at, DROP ends_at, DROP content');
    }
}
