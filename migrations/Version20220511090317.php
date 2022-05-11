<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220511090317 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE inscripciones (id INT AUTO_INCREMENT NOT NULL, usuario_id INT NOT NULL, fiestas_id INT NOT NULL, INDEX IDX_D30F498DB38439E (usuario_id), INDEX IDX_D30F4985E534DAD (fiestas_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE inscripciones ADD CONSTRAINT FK_D30F498DB38439E FOREIGN KEY (usuario_id) REFERENCES usuario (id)');
        $this->addSql('ALTER TABLE inscripciones ADD CONSTRAINT FK_D30F4985E534DAD FOREIGN KEY (fiestas_id) REFERENCES fiestas (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE inscripciones');
    }
}
