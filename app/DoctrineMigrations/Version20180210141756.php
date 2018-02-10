<?php declare(strict_types = 1);

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180210141756 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE period_type (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE period ADD period_type_id INT DEFAULT NULL, DROP type');
        $this->addSql('ALTER TABLE period ADD CONSTRAINT FK_C5B81ECE3EA529CB FOREIGN KEY (period_type_id) REFERENCES period_type (id)');
        $this->addSql('CREATE INDEX IDX_C5B81ECE3EA529CB ON period (period_type_id)');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE period DROP FOREIGN KEY FK_C5B81ECE3EA529CB');
        $this->addSql('DROP TABLE period_type');
        $this->addSql('DROP INDEX IDX_C5B81ECE3EA529CB ON period');
        $this->addSql('ALTER TABLE period ADD type VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, DROP period_type_id');
    }
}
