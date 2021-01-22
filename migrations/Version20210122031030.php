<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210122031030 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE demande ADD bien_id INT NOT NULL');
        $this->addSql('ALTER TABLE demande ADD CONSTRAINT FK_2694D7A5BD95B80F FOREIGN KEY (bien_id) REFERENCES biens (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_2694D7A5BD95B80F ON demande (bien_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE demande DROP FOREIGN KEY FK_2694D7A5BD95B80F');
        $this->addSql('DROP INDEX UNIQ_2694D7A5BD95B80F ON demande');
        $this->addSql('ALTER TABLE demande DROP bien_id');
    }
}
