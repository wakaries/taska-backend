<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221019153443 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE import (id VARCHAR(255) NOT NULL, creation_date DATETIME NOT NULL, data LONGTEXT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE item (id VARCHAR(255) NOT NULL, epic_id VARCHAR(255) DEFAULT NULL, data LONGTEXT NOT NULL, status VARCHAR(20) NOT NULL, INDEX IDX_1F1B251E6B71E00E (epic_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE item ADD CONSTRAINT FK_1F1B251E6B71E00E FOREIGN KEY (epic_id) REFERENCES import (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE item DROP FOREIGN KEY FK_1F1B251E6B71E00E');
        $this->addSql('DROP TABLE import');
        $this->addSql('DROP TABLE item');
        $this->addSql('ALTER TABLE task CHANGE id id INT AUTO_INCREMENT NOT NULL, CHANGE epic_id epic_id INT NOT NULL, CHANGE release_id release_id INT DEFAULT NULL, CHANGE creation_user_id creation_user_id INT NOT NULL, CHANGE current_user_id current_user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE project CHANGE id id INT AUTO_INCREMENT NOT NULL, CHANGE space_id space_id INT NOT NULL');
        $this->addSql('ALTER TABLE watcher CHANGE id id INT AUTO_INCREMENT NOT NULL, CHANGE user_id user_id INT NOT NULL, CHANGE task_id task_id INT NOT NULL, CHANGE level level INT NOT NULL');
        $this->addSql('ALTER TABLE user_project CHANGE id id INT AUTO_INCREMENT NOT NULL, CHANGE user_id user_id INT NOT NULL, CHANGE project_id project_id INT NOT NULL');
        $this->addSql('ALTER TABLE `release` CHANGE id id INT AUTO_INCREMENT NOT NULL, CHANGE project_id project_id INT NOT NULL');
        $this->addSql('ALTER TABLE worklog CHANGE id id INT AUTO_INCREMENT NOT NULL, CHANGE task_id task_id INT NOT NULL, CHANGE user_id user_id INT NOT NULL, CHANGE worklog worklog INT NOT NULL');
        $this->addSql('ALTER TABLE user CHANGE id id INT AUTO_INCREMENT NOT NULL, CHANGE space_id space_id INT NOT NULL');
        $this->addSql('ALTER TABLE epic CHANGE id id INT AUTO_INCREMENT NOT NULL, CHANGE project_id project_id INT NOT NULL');
        $this->addSql('ALTER TABLE task_tag CHANGE task_id task_id INT NOT NULL, CHANGE tag_id tag_id INT NOT NULL');
        $this->addSql('ALTER TABLE space CHANGE id id INT AUTO_INCREMENT NOT NULL');
        $this->addSql('ALTER TABLE comment CHANGE id id INT AUTO_INCREMENT NOT NULL, CHANGE task_id task_id INT NOT NULL, CHANGE user_id user_id INT NOT NULL');
        $this->addSql('ALTER TABLE tag CHANGE id id INT AUTO_INCREMENT NOT NULL, CHANGE project_id project_id INT NOT NULL');
    }
}
