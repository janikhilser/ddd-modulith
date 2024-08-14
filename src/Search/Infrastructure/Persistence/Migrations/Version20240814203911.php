<?php

declare(strict_types=1);

namespace App\Search\Infrastructure\Persistence\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240814203911 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE Book (id CHAR(36) NOT NULL, title_title VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE book_isbns (book_id CHAR(36) NOT NULL, isbn_id INT NOT NULL, INDEX IDX_5C6981CB16A2B381 (book_id), UNIQUE INDEX UNIQ_5C6981CBAFFF1118 (isbn_id), PRIMARY KEY(book_id, isbn_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE isbn (id INT AUTO_INCREMENT NOT NULL, isbn VARCHAR(13) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE book_isbns ADD CONSTRAINT FK_5C6981CB16A2B381 FOREIGN KEY (book_id) REFERENCES Book (id)');
        $this->addSql('ALTER TABLE book_isbns ADD CONSTRAINT FK_5C6981CBAFFF1118 FOREIGN KEY (isbn_id) REFERENCES isbn (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE book_isbns DROP FOREIGN KEY FK_5C6981CB16A2B381');
        $this->addSql('ALTER TABLE book_isbns DROP FOREIGN KEY FK_5C6981CBAFFF1118');
        $this->addSql('DROP TABLE Book');
        $this->addSql('DROP TABLE book_isbns');
        $this->addSql('DROP TABLE isbn');
    }
}
