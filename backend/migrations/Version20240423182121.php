<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240423182121 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE courses DROP user_courses_statuses');
        $this->addSql('ALTER TABLE quiz CHANGE right_answer right_answer TEXT NOT NULL, CHANGE wrong_answer wrong_answer TEXT NOT NULL');
        $this->addSql('ALTER TABLE user_courses_status RENAME INDEX idx_4fac2f335359e06e TO IDX_4FAC2F33F9295384');
        $this->addSql('ALTER TABLE user_courses_status RENAME INDEX idx_4fac2f339d86650f TO IDX_4FAC2F33A76ED395');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE courses ADD user_courses_statuses VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE user_courses_status RENAME INDEX idx_4fac2f33f9295384 TO IDX_4FAC2F335359E06E');
        $this->addSql('ALTER TABLE user_courses_status RENAME INDEX idx_4fac2f33a76ed395 TO IDX_4FAC2F339D86650F');
        $this->addSql('ALTER TABLE quiz CHANGE right_answer right_answer TINYTEXT NOT NULL, CHANGE wrong_answer wrong_answer TINYTEXT NOT NULL');
    }
}
