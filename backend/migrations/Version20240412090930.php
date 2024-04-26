<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240412090930 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE courses ADD user_courses_statuses VARCHAR(255) NULL, CHANGE description description TEXT DEFAULT NULL');
        $this->addSql('ALTER TABLE quiz_sets CHANGE description description TEXT DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE courses DROP user_courses_statuses, CHANGE description description VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE quiz_sets CHANGE description description VARCHAR(255) DEFAULT NULL');
    }
}
