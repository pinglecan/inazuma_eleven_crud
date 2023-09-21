<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230920120504 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE character_team (character_id INT NOT NULL, team_id INT NOT NULL, INDEX IDX_D31CB2871136BE75 (character_id), INDEX IDX_D31CB287296CD8AE (team_id), PRIMARY KEY(character_id, team_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE character_team ADD CONSTRAINT FK_D31CB2871136BE75 FOREIGN KEY (character_id) REFERENCES `character` (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE character_team ADD CONSTRAINT FK_D31CB287296CD8AE FOREIGN KEY (team_id) REFERENCES team (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE character_team DROP FOREIGN KEY FK_D31CB2871136BE75');
        $this->addSql('ALTER TABLE character_team DROP FOREIGN KEY FK_D31CB287296CD8AE');
        $this->addSql('DROP TABLE character_team');
    }
}
