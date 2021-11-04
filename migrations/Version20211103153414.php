<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211103153414 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE article (id INT NOT NULL, name VARCHAR(100) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE article_attribute (article_id INT NOT NULL, attribute_id INT NOT NULL, PRIMARY KEY(article_id, attribute_id))');
        $this->addSql('CREATE INDEX IDX_204FBFDF7294869C ON article_attribute (article_id)');
        $this->addSql('CREATE INDEX IDX_204FBFDFB6E62EFA ON article_attribute (attribute_id)');
        $this->addSql('CREATE TABLE attribute (id INT NOT NULL, key VARCHAR(100) NOT NULL, value VARCHAR(100) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('ALTER TABLE article_attribute ADD CONSTRAINT FK_204FBFDF7294869C FOREIGN KEY (article_id) REFERENCES article (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE article_attribute ADD CONSTRAINT FK_204FBFDFB6E62EFA FOREIGN KEY (attribute_id) REFERENCES attribute (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE article_attribute DROP CONSTRAINT FK_204FBFDF7294869C');
        $this->addSql('ALTER TABLE article_attribute DROP CONSTRAINT FK_204FBFDFB6E62EFA');
        $this->addSql('DROP TABLE article');
        $this->addSql('DROP TABLE article_attribute');
        $this->addSql('DROP TABLE attribute');
    }
}
