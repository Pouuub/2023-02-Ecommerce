<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230204142953 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE article ADD price DOUBLE PRECISION NOT NULL, DROP price_ht, DROP tva, DROP price_ttc');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE article ADD tva DOUBLE PRECISION NOT NULL, ADD price_ttc DOUBLE PRECISION NOT NULL, CHANGE price price_ht DOUBLE PRECISION NOT NULL');
    }
}
