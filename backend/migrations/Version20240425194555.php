<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240425194555 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE quiz CHANGE question question TEXT NOT NULL, CHANGE right_answer right_answer JSON NOT NULL, CHANGE wrong_answer wrong_answer JSON NOT NULL');
        $this->addSql('ALTER TABLE user_courses_status CHANGE courses_id courses_id INT DEFAULT NULL, CHANGE user_id user_id INT DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user_courses_status CHANGE courses_id courses_id INT NOT NULL, CHANGE user_id user_id INT NOT NULL');
        $this->addSql('ALTER TABLE quiz CHANGE question question VARCHAR(255) NOT NULL, CHANGE right_answer right_answer TEXT NOT NULL, CHANGE wrong_answer wrong_answer TEXT NOT NULL');
    }
}
