<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240903081055 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__card_scan AS SELECT id, user_id, time_period_id, date FROM card_scan');
        $this->addSql('DROP TABLE card_scan');
        $this->addSql('CREATE TABLE card_scan (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, user_id INTEGER NOT NULL, time_period_id INTEGER NOT NULL, date DATE NOT NULL --(DC2Type:date_immutable)
        , CONSTRAINT FK_2880B10CA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE NO ACTION NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_2880B10C7EFD7106 FOREIGN KEY (time_period_id) REFERENCES time_period (id) ON UPDATE NO ACTION ON DELETE NO ACTION NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO card_scan (id, user_id, time_period_id, date) SELECT id, user_id, time_period_id, date FROM __temp__card_scan');
        $this->addSql('DROP TABLE __temp__card_scan');
        $this->addSql('CREATE INDEX IDX_2880B10C7EFD7106 ON card_scan (time_period_id)');
        $this->addSql('CREATE INDEX IDX_2880B10CA76ED395 ON card_scan (user_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__card_scan AS SELECT id, user_id, time_period_id, date FROM card_scan');
        $this->addSql('DROP TABLE card_scan');
        $this->addSql('CREATE TABLE card_scan (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, user_id INTEGER NOT NULL, time_period_id INTEGER NOT NULL, date DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , CONSTRAINT FK_2880B10CA76ED395 FOREIGN KEY (user_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_2880B10C7EFD7106 FOREIGN KEY (time_period_id) REFERENCES time_period (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO card_scan (id, user_id, time_period_id, date) SELECT id, user_id, time_period_id, date FROM __temp__card_scan');
        $this->addSql('DROP TABLE __temp__card_scan');
        $this->addSql('CREATE INDEX IDX_2880B10CA76ED395 ON card_scan (user_id)');
        $this->addSql('CREATE INDEX IDX_2880B10C7EFD7106 ON card_scan (time_period_id)');
    }
}
