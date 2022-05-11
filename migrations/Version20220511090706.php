<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220511090706 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE contacto ADD usuario_id INT NOT NULL');
        $this->addSql('ALTER TABLE contacto ADD CONSTRAINT FK_2741493CDB38439E FOREIGN KEY (usuario_id) REFERENCES usuario (id)');
        $this->addSql('CREATE INDEX IDX_2741493CDB38439E ON contacto (usuario_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE contacto DROP FOREIGN KEY FK_2741493CDB38439E');
        $this->addSql('DROP INDEX IDX_2741493CDB38439E ON contacto');
        $this->addSql('ALTER TABLE contacto DROP usuario_id');
    }
}
