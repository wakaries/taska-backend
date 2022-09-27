<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220927153319 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE UNIQUE INDEX UNIQ_2FB3D0EED17F50A6 ON project (uuid)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_9E47031DD17F50A6 ON `release` (uuid)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_2972C13AD17F50A6 ON space (uuid)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_389B783D17F50A6 ON tag (uuid)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_527EDB25D17F50A6 ON task (uuid)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX UNIQ_2FB3D0EED17F50A6 ON project');
        $this->addSql('DROP INDEX UNIQ_9E47031DD17F50A6 ON `release`');
        $this->addSql('DROP INDEX UNIQ_2972C13AD17F50A6 ON space');
        $this->addSql('DROP INDEX UNIQ_389B783D17F50A6 ON tag');
        $this->addSql('DROP INDEX UNIQ_527EDB25D17F50A6 ON task');
    }
}
