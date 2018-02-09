<?php declare(strict_types = 1);

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180209155855 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE period (project_id INT NOT NULL, user_id INT NOT NULL, type VARCHAR(255) NOT NULL, start DATETIME NOT NULL, INDEX IDX_C5B81ECE166D1F9C (project_id), INDEX IDX_C5B81ECEA76ED395 (user_id), PRIMARY KEY(project_id, user_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE period ADD CONSTRAINT FK_C5B81ECE166D1F9C FOREIGN KEY (project_id) REFERENCES project (id)');
        $this->addSql('ALTER TABLE period ADD CONSTRAINT FK_C5B81ECEA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('DROP TABLE mission');
        $this->addSql('ALTER TABLE project ADD User INT DEFAULT NULL');
        $this->addSql('ALTER TABLE project ADD CONSTRAINT FK_2FB3D0EE2DA17977 FOREIGN KEY (User) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_2FB3D0EE2DA17977 ON project (User)');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE mission (project_id INT NOT NULL, user_id INT NOT NULL, hidden TINYINT(1) DEFAULT \'0\' NOT NULL, INDEX IDX_9067F23C166D1F9C (project_id), INDEX IDX_9067F23CA76ED395 (user_id), PRIMARY KEY(project_id, user_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE mission ADD CONSTRAINT FK_9067F23C166D1F9C FOREIGN KEY (project_id) REFERENCES project (id)');
        $this->addSql('ALTER TABLE mission ADD CONSTRAINT FK_9067F23CA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('DROP TABLE period');
        $this->addSql('ALTER TABLE project DROP FOREIGN KEY FK_2FB3D0EE2DA17977');
        $this->addSql('DROP INDEX IDX_2FB3D0EE2DA17977 ON project');
        $this->addSql('ALTER TABLE project DROP User');
    }
}
