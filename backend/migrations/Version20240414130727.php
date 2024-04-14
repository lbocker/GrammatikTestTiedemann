<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240414130727 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE user_courses_status (id INT AUTO_INCREMENT NOT NULL, status VARCHAR(255) NOT NULL, courses_id INT DEFAULT NULL, user_id INT DEFAULT NULL, INDEX IDX_4FAC2F335359E06E (courses_id), INDEX IDX_4FAC2F339D86650F (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('ALTER TABLE user_courses_status ADD CONSTRAINT FK_4FAC2F335359E06E FOREIGN KEY (courses_id) REFERENCES courses (id)');
        $this->addSql('ALTER TABLE user_courses_status ADD CONSTRAINT FK_4FAC2F339D86650F FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE quiz ADD points INT DEFAULT 0 NOT NULL, CHANGE question question VARCHAR(255) NOT NULL, CHANGE right_answer right_answer TINYTEXT NOT NULL, CHANGE wrong_answer wrong_answer TINYTEXT NOT NULL, CHANGE type type VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE quiz_sets CHANGE title title VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE user CHANGE points points INT DEFAULT 0 NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user_courses_status DROP FOREIGN KEY FK_4FAC2F335359E06E');
        $this->addSql('ALTER TABLE user_courses_status DROP FOREIGN KEY FK_4FAC2F339D86650F');
        $this->addSql('DROP TABLE user_courses_status');
        $this->addSql('ALTER TABLE user CHANGE points points INT NOT NULL');
        $this->addSql('ALTER TABLE quiz DROP points, CHANGE question question VARCHAR(255) DEFAULT NULL, CHANGE right_answer right_answer VARCHAR(255) DEFAULT NULL, CHANGE wrong_answer wrong_answer VARCHAR(255) DEFAULT NULL, CHANGE type type VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE quiz_sets CHANGE title title VARCHAR(255) DEFAULT NULL');
    }
}
