<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220409200328 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE invoice (id INT AUTO_INCREMENT NOT NULL, invoice_date DATE NOT NULL, invoice_number INT NOT NULL, custumer_id INT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE invoice_lines (id INT AUTO_INCREMENT NOT NULL, invoice_id INT DEFAULT NULL, description LONGTEXT NOT NULL, quantity INT NOT NULL, amount NUMERIC(10, 0) NOT NULL, vat_amount NUMERIC(10, 0) NOT NULL, total NUMERIC(10, 0) NOT NULL, INDEX IDX_72DBDC232989F1FD (invoice_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE invoice_lines ADD CONSTRAINT FK_72DBDC232989F1FD FOREIGN KEY (invoice_id) REFERENCES invoice (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE invoice_lines DROP FOREIGN KEY FK_72DBDC232989F1FD');
        $this->addSql('DROP TABLE invoice');
        $this->addSql('DROP TABLE invoice_lines');
    }
}
