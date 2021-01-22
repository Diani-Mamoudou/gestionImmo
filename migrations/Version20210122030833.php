<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210122030833 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE biens DROP FOREIGN KEY FK_1F9004DD80E95E18');
        $this->addSql('DROP INDEX UNIQ_1F9004DD80E95E18 ON biens');
        $this->addSql('ALTER TABLE biens DROP demande_id');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE biens ADD demande_id INT NOT NULL');
        $this->addSql('ALTER TABLE biens ADD CONSTRAINT FK_1F9004DD80E95E18 FOREIGN KEY (demande_id) REFERENCES demande (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_1F9004DD80E95E18 ON biens (demande_id)');
    }
}
