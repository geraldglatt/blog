<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230207200134 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE tags_posts (tag_id INT NOT NULL, post_id INT NOT NULL, INDEX IDX_E3394CA2BAD26311 (tag_id), INDEX IDX_E3394CA24B89032C (post_id), PRIMARY KEY(tag_id, post_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE tags_posts ADD CONSTRAINT FK_E3394CA2BAD26311 FOREIGN KEY (tag_id) REFERENCES tag (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE tags_posts ADD CONSTRAINT FK_E3394CA24B89032C FOREIGN KEY (post_id) REFERENCES post (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE tag_posts DROP FOREIGN KEY FK_AAB1A3FC4B89032C');
        $this->addSql('ALTER TABLE tag_posts DROP FOREIGN KEY FK_AAB1A3FCBAD26311');
        $this->addSql('DROP TABLE tag_posts');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE tag_posts (tag_id INT NOT NULL, post_id INT NOT NULL, INDEX IDX_AAB1A3FC4B89032C (post_id), INDEX IDX_AAB1A3FCBAD26311 (tag_id), PRIMARY KEY(tag_id, post_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE tag_posts ADD CONSTRAINT FK_AAB1A3FC4B89032C FOREIGN KEY (post_id) REFERENCES post (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE tag_posts ADD CONSTRAINT FK_AAB1A3FCBAD26311 FOREIGN KEY (tag_id) REFERENCES tag (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE tags_posts DROP FOREIGN KEY FK_E3394CA2BAD26311');
        $this->addSql('ALTER TABLE tags_posts DROP FOREIGN KEY FK_E3394CA24B89032C');
        $this->addSql('DROP TABLE tags_posts');
    }
}
