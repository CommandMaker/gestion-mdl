<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240916082250 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE foyer_open_history (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, user_id INTEGER NOT NULL, date DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , CONSTRAINT FK_5CCF7697A76ED395 FOREIGN KEY (user_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_5CCF7697A76ED395 ON foyer_open_history (user_id)');
        $this->addSql('CREATE TEMPORARY TABLE __temp__card_scan AS SELECT id, user_id, time_period_id, date FROM card_scan');
        $this->addSql('DROP TABLE card_scan');
        $this->addSql('CREATE TABLE card_scan (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, user_id INTEGER NOT NULL, time_period_id INTEGER NOT NULL, date DATE NOT NULL --(DC2Type:date_immutable)
        , CONSTRAINT FK_2880B10CA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE NO ACTION NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_2880B10C7EFD7106 FOREIGN KEY (time_period_id) REFERENCES time_period (id) ON UPDATE NO ACTION ON DELETE NO ACTION NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO card_scan (id, user_id, time_period_id, date) SELECT id, user_id, time_period_id, date FROM __temp__card_scan');
        $this->addSql('DROP TABLE __temp__card_scan');
        $this->addSql('CREATE INDEX IDX_2880B10CA76ED395 ON card_scan (user_id)');
        $this->addSql('CREATE INDEX IDX_2880B10C7EFD7106 ON card_scan (time_period_id)');
        $this->addSql('CREATE TEMPORARY TABLE __temp__time_period AS SELECT id, display_name, start_time, end_time FROM time_period');
        $this->addSql('DROP TABLE time_period');
        $this->addSql('CREATE TABLE time_period (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, display_name VARCHAR(255) NOT NULL, start_time TIME NOT NULL --(DC2Type:time_immutable)
        , end_time TIME NOT NULL --(DC2Type:time_immutable)
        )');
        $this->addSql('INSERT INTO time_period (id, display_name, start_time, end_time) SELECT id, display_name, start_time, end_time FROM __temp__time_period');
        $this->addSql('DROP TABLE __temp__time_period');
        $this->addSql('CREATE TEMPORARY TABLE __temp__user AS SELECT id, subscription_type_id, firstname, lastname, code, gender, grade, roles, password, is_admin, created_at FROM user');
        $this->addSql('DROP TABLE user');
        $this->addSql('CREATE TABLE user (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, subscription_type_id INTEGER NOT NULL, firstname VARCHAR(255) NOT NULL, lastname VARCHAR(255) NOT NULL, code VARCHAR(255) NOT NULL, gender VARCHAR(255) NOT NULL, grade VARCHAR(255) NOT NULL, roles CLOB NOT NULL --(DC2Type:json)
        , password VARCHAR(255) DEFAULT NULL, is_admin BOOLEAN DEFAULT 0 NOT NULL, created_at DATE NOT NULL --(DC2Type:date_immutable)
        , CONSTRAINT FK_8D93D649B6596C08 FOREIGN KEY (subscription_type_id) REFERENCES subscription_type (id) ON UPDATE NO ACTION ON DELETE NO ACTION NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO user (id, subscription_type_id, firstname, lastname, code, gender, grade, roles, password, is_admin, created_at) SELECT id, subscription_type_id, firstname, lastname, code, gender, grade, roles, password, is_admin, created_at FROM __temp__user');
        $this->addSql('DROP TABLE __temp__user');
        $this->addSql('CREATE INDEX IDX_8D93D649B6596C08 ON user (subscription_type_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE foyer_open_history');
        $this->addSql('CREATE TEMPORARY TABLE __temp__card_scan AS SELECT id, user_id, time_period_id, date FROM card_scan');
        $this->addSql('DROP TABLE card_scan');
        $this->addSql('CREATE TABLE card_scan (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, user_id INTEGER NOT NULL, time_period_id INTEGER NOT NULL, date DATE NOT NULL --(DC2Type:date_immutable)
        , CONSTRAINT FK_2880B10CA76ED395 FOREIGN KEY (user_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_2880B10C7EFD7106 FOREIGN KEY (time_period_id) REFERENCES time_period (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO card_scan (id, user_id, time_period_id, date) SELECT id, user_id, time_period_id, date FROM __temp__card_scan');
        $this->addSql('DROP TABLE __temp__card_scan');
        $this->addSql('CREATE INDEX IDX_2880B10CA76ED395 ON card_scan (user_id)');
        $this->addSql('CREATE INDEX IDX_2880B10C7EFD7106 ON card_scan (time_period_id)');
        $this->addSql('CREATE TEMPORARY TABLE __temp__time_period AS SELECT id, display_name, start_time, end_time FROM time_period');
        $this->addSql('DROP TABLE time_period');
        $this->addSql('CREATE TABLE time_period (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, display_name VARCHAR(255) NOT NULL, start_time TIME NOT NULL --(DC2Type:time_immutable)
        , end_time TIME NOT NULL --(DC2Type:time_immutable)
        )');
        $this->addSql('INSERT INTO time_period (id, display_name, start_time, end_time) SELECT id, display_name, start_time, end_time FROM __temp__time_period');
        $this->addSql('DROP TABLE __temp__time_period');
        $this->addSql('CREATE TEMPORARY TABLE __temp__user AS SELECT id, subscription_type_id, firstname, lastname, code, gender, grade, roles, password, is_admin, created_at FROM "user"');
        $this->addSql('DROP TABLE "user"');
        $this->addSql('CREATE TABLE "user" (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, subscription_type_id INTEGER NOT NULL, firstname VARCHAR(255) NOT NULL, lastname VARCHAR(255) NOT NULL, code VARCHAR(255) NOT NULL, gender VARCHAR(255) NOT NULL, grade VARCHAR(255) NOT NULL, roles CLOB NOT NULL --(DC2Type:json)
        , password VARCHAR(255) DEFAULT NULL, is_admin BOOLEAN DEFAULT 0 NOT NULL, created_at DATE NOT NULL --(DC2Type:date_immutable)
        , CONSTRAINT FK_8D93D649B6596C08 FOREIGN KEY (subscription_type_id) REFERENCES subscription_type (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO "user" (id, subscription_type_id, firstname, lastname, code, gender, grade, roles, password, is_admin, created_at) SELECT id, subscription_type_id, firstname, lastname, code, gender, grade, roles, password, is_admin, created_at FROM __temp__user');
        $this->addSql('DROP TABLE __temp__user');
        $this->addSql('CREATE INDEX IDX_8D93D649B6596C08 ON "user" (subscription_type_id)');
    }
}
