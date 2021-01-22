<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210122185034 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE demande CHANGE user_id user_reserv_id INT NOT NULL');
        $this->addSql('ALTER TABLE demande ADD CONSTRAINT FK_2694D7A57148D854 FOREIGN KEY (user_reserv_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_2694D7A57148D854 ON demande (user_reserv_id)');
        $this->addSql('ALTER TABLE user ADD telephone VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE demande DROP FOREIGN KEY FK_2694D7A57148D854');
        $this->addSql('DROP INDEX IDX_2694D7A57148D854 ON demande');
        $this->addSql('ALTER TABLE demande CHANGE user_reserv_id user_id INT NOT NULL');
        $this->addSql('ALTER TABLE user DROP telephone');
    }
}
