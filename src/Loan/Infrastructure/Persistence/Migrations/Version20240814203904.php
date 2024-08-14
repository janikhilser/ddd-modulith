<?php

declare(strict_types=1);

namespace App\Loan\Infrastructure\Persistence\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240814203904 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE Book (id CHAR(36) NOT NULL, publicationId CHAR(36) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE Book_Loans (book_id CHAR(36) NOT NULL, loan_id CHAR(36) NOT NULL, INDEX IDX_29C741116A2B381 (book_id), UNIQUE INDEX UNIQ_29C7411CE73868F (loan_id), PRIMARY KEY(book_id, loan_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE Loan (id CHAR(36) NOT NULL, sequence INT NOT NULL, returned TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE Publication (id CHAR(36) NOT NULL, isbn VARCHAR(13) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE Book_Loans ADD CONSTRAINT FK_29C741116A2B381 FOREIGN KEY (book_id) REFERENCES Book (id)');
        $this->addSql('ALTER TABLE Book_Loans ADD CONSTRAINT FK_29C7411CE73868F FOREIGN KEY (loan_id) REFERENCES Loan (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE Book_Loans DROP FOREIGN KEY FK_29C741116A2B381');
        $this->addSql('ALTER TABLE Book_Loans DROP FOREIGN KEY FK_29C7411CE73868F');
        $this->addSql('DROP TABLE Book');
        $this->addSql('DROP TABLE Book_Loans');
        $this->addSql('DROP TABLE Loan');
        $this->addSql('DROP TABLE Publication');
    }
}
