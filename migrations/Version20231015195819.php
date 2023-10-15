<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231015195819 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE chat (id INT AUTO_INCREMENT NOT NULL, sender_id_id INT NOT NULL, reciver_id_id INT NOT NULL, body VARCHAR(255) DEFAULT NULL, sent_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', recived_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', viewed_or_not TINYINT(1) NOT NULL, INDEX IDX_659DF2AA6061F7CF (sender_id_id), INDEX IDX_659DF2AAA5124D3C (reciver_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE online_user (id INT AUTO_INCREMENT NOT NULL, user_id_id INT NOT NULL, id_last_msg_to_get_id INT NOT NULL, UNIQUE INDEX UNIQ_8752D6EF9D86650F (user_id_id), UNIQUE INDEX UNIQ_8752D6EF83C57546 (id_last_msg_to_get_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, first_name VARCHAR(255) NOT NULL, last_name VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, age INT NOT NULL, cin INT NOT NULL, image VARCHAR(255) DEFAULT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE chat ADD CONSTRAINT FK_659DF2AA6061F7CF FOREIGN KEY (sender_id_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE chat ADD CONSTRAINT FK_659DF2AAA5124D3C FOREIGN KEY (reciver_id_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE online_user ADD CONSTRAINT FK_8752D6EF9D86650F FOREIGN KEY (user_id_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE online_user ADD CONSTRAINT FK_8752D6EF83C57546 FOREIGN KEY (id_last_msg_to_get_id) REFERENCES chat (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE chat DROP FOREIGN KEY FK_659DF2AA6061F7CF');
        $this->addSql('ALTER TABLE chat DROP FOREIGN KEY FK_659DF2AAA5124D3C');
        $this->addSql('ALTER TABLE online_user DROP FOREIGN KEY FK_8752D6EF9D86650F');
        $this->addSql('ALTER TABLE online_user DROP FOREIGN KEY FK_8752D6EF83C57546');
        $this->addSql('DROP TABLE chat');
        $this->addSql('DROP TABLE online_user');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
