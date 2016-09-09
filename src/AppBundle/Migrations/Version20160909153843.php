<?php

namespace AppBundle\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20160909153843 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE event ADD social_id VARCHAR(255) NOT NULL, ADD start_at LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:array)\', ADD end_at LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:array)\', ADD created_at DATETIME DEFAULT NULL, ADD creator LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\', ADD status VARCHAR(50) NOT NULL, ADD summary VARCHAR(255) NOT NULL');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE event DROP social_id, DROP start_at, DROP end_at, DROP created_at, DROP creator, DROP status, DROP summary');
    }
}
