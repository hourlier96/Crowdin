<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20181211154358 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE languages DROP FOREIGN KEY FK_A0D153795D237A9A');
        $this->addSql('DROP INDEX IDX_A0D153795D237A9A ON languages');
        $this->addSql('ALTER TABLE languages DROP languages_id, DROP related_id');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE languages ADD languages_id INT DEFAULT NULL, ADD related_id INT NOT NULL');
        $this->addSql('ALTER TABLE languages ADD CONSTRAINT FK_A0D153795D237A9A FOREIGN KEY (languages_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_A0D153795D237A9A ON languages (languages_id)');
    }
}
