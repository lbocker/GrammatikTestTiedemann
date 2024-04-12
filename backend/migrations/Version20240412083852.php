<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240412083852 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user_courses_status DROP FOREIGN KEY FK_4FAC2F335359E06E');
        $this->addSql('ALTER TABLE user_courses_status DROP FOREIGN KEY FK_4FAC2F339D86650F');
        $this->addSql('ALTER TABLE courses CHANGE description description TEXT DEFAULT NULL');
        $this->addSql('ALTER TABLE quiz DROP points, CHANGE question question VARCHAR(255) DEFAULT NULL, CHANGE right_answer right_answer VARCHAR(255) DEFAULT NULL, CHANGE wrong_answer wrong_answer VARCHAR(255) DEFAULT NULL, CHANGE type type VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE quiz_sets CHANGE description description TEXT DEFAULT NULL');
        $this->addSql('ALTER TABLE user CHANGE points points INT NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE user_courses_status (id INT AUTO_INCREMENT NOT NULL, status VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_0900_ai_ci`, courses_id_id INT DEFAULT NULL, user_id_id INT DEFAULT NULL, INDEX IDX_4FAC2F335359E06E (courses_id_id), INDEX IDX_4FAC2F339D86650F (user_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_0900_ai_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE user_courses_status ADD CONSTRAINT FK_4FAC2F335359E06E FOREIGN KEY (courses_id_id) REFERENCES courses (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE user_courses_status ADD CONSTRAINT FK_4FAC2F339D86650F FOREIGN KEY (user_id_id) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE courses CHANGE description description VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE user CHANGE points points INT DEFAULT 0 NOT NULL');
        $this->addSql('ALTER TABLE quiz ADD points INT DEFAULT 0 NOT NULL, CHANGE question question VARCHAR(255) NOT NULL, CHANGE right_answer right_answer VARCHAR(255) NOT NULL, CHANGE wrong_answer wrong_answer VARCHAR(255) NOT NULL, CHANGE type type VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE quiz_sets CHANGE description description VARCHAR(255) DEFAULT NULL');
    }
}
