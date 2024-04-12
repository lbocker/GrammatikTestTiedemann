<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240403092215 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE courses DROP FOREIGN KEY FK_A9A55A4CE65773DE');
        $this->addSql('DROP INDEX IDX_A9A55A4CE65773DE ON courses');
        $this->addSql('ALTER TABLE courses DROP quiz_sets_id');
        $this->addSql('ALTER TABLE quiz_sets ADD courses_id INT NOT NULL');
        $this->addSql('ALTER TABLE quiz_sets ADD CONSTRAINT FK_5E7CB98AF9295384 FOREIGN KEY (courses_id) REFERENCES courses (id)');
        $this->addSql('CREATE INDEX IDX_5E7CB98AF9295384 ON quiz_sets (courses_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE courses ADD quiz_sets_id INT NOT NULL');
        $this->addSql('ALTER TABLE courses ADD CONSTRAINT FK_A9A55A4CE65773DE FOREIGN KEY (quiz_sets_id) REFERENCES quiz_sets (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_A9A55A4CE65773DE ON courses (quiz_sets_id)');
        $this->addSql('ALTER TABLE quiz_sets DROP FOREIGN KEY FK_5E7CB98AF9295384');
        $this->addSql('DROP INDEX IDX_5E7CB98AF9295384 ON quiz_sets');
        $this->addSql('ALTER TABLE quiz_sets DROP courses_id');
    }
}
