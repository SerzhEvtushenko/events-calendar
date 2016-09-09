<?php

namespace AppBundle\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20160909144016 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE event (id INT AUTO_INCREMENT NOT NULL, account_id INT DEFAULT NULL, INDEX IDX_3BAE0AA79B6B5FBA (account_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE social_account (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, social_id VARCHAR(255) NOT NULL, provider_type VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL, access_token LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\', events_updated_at DATETIME DEFAULT NULL, INDEX IDX_F24D8339A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, first_name VARCHAR(255) DEFAULT NULL, last_name VARCHAR(255) DEFAULT NULL, email VARCHAR(255) NOT NULL, active TINYINT(1) NOT NULL, enable TINYINT(1) NOT NULL, password VARCHAR(255) DEFAULT NULL, activation_code VARCHAR(255) DEFAULT NULL, created_at DATETIME NOT NULL, activated_at DATETIME DEFAULT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE event ADD CONSTRAINT FK_3BAE0AA79B6B5FBA FOREIGN KEY (account_id) REFERENCES social_account (id)');
        $this->addSql('ALTER TABLE social_account ADD CONSTRAINT FK_F24D8339A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE event DROP FOREIGN KEY FK_3BAE0AA79B6B5FBA');
        $this->addSql('ALTER TABLE social_account DROP FOREIGN KEY FK_F24D8339A76ED395');
        $this->addSql('DROP TABLE event');
        $this->addSql('DROP TABLE social_account');
        $this->addSql('DROP TABLE user');
    }
}
