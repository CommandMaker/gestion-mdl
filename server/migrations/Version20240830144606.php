<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240830144606 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE time_period (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, display_name VARCHAR(255) NOT NULL, start_time TIME NOT NULL --(DC2Type:time_immutable)
        , end_time TIME NOT NULL --(DC2Type:time_immutable)
        )');
        $this->addSql('CREATE TEMPORARY TABLE __temp__user AS SELECT id, subscription_type_id, firstname, lastname, code, gender, grade, is_admin FROM user');
        $this->addSql('DROP TABLE user');
        $this->addSql('CREATE TABLE user (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, subscription_type_id INTEGER NOT NULL, firstname VARCHAR(255) NOT NULL, lastname VARCHAR(255) NOT NULL, code VARCHAR(255) NOT NULL, gender VARCHAR(255) NOT NULL, grade VARCHAR(255) NOT NULL, is_admin BOOLEAN DEFAULT 0 NOT NULL, CONSTRAINT FK_8D93D649B6596C08 FOREIGN KEY (subscription_type_id) REFERENCES subscription_type (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO user (id, subscription_type_id, firstname, lastname, code, gender, grade, is_admin) SELECT id, subscription_type_id, firstname, lastname, code, gender, grade, is_admin FROM __temp__user');
        $this->addSql('DROP TABLE __temp__user');
        $this->addSql('CREATE INDEX IDX_8D93D649B6596C08 ON user (subscription_type_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE time_period');
        $this->addSql('CREATE TEMPORARY TABLE __temp__user AS SELECT id, subscription_type_id, firstname, lastname, code, gender, grade, is_admin FROM "user"');
        $this->addSql('DROP TABLE "user"');
        $this->addSql('CREATE TABLE "user" (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, subscription_type_id INTEGER NOT NULL, firstname VARCHAR(255) NOT NULL, lastname VARCHAR(255) NOT NULL, code VARCHAR(255) NOT NULL, gender VARCHAR(255) NOT NULL, grade VARCHAR(255) NOT NULL, is_admin BOOLEAN DEFAULT 0 NOT NULL, CONSTRAINT FK_8D93D649B6596C08 FOREIGN KEY (subscription_type_id) REFERENCES subscriptionType (id) ON UPDATE NO ACTION ON DELETE NO ACTION NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO "user" (id, subscription_type_id, firstname, lastname, code, gender, grade, is_admin) SELECT id, subscription_type_id, firstname, lastname, code, gender, grade, is_admin FROM __temp__user');
        $this->addSql('DROP TABLE __temp__user');
        $this->addSql('CREATE INDEX IDX_8D93D649B6596C08 ON "user" (subscription_type_id)');
    }
}
