<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20241124214345 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE todo_list (name VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, deleted_at DATETIME(6) DEFAULT NULL, created_at DATETIME(6) NOT NULL, updated_at DATETIME(6) NOT NULL, id CHAR(36) NOT NULL, user_id CHAR(36) NOT NULL, INDEX IDX_1B199E07A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE todo_list_item (description LONGTEXT NOT NULL, completed TINYINT(1) NOT NULL, deleted_at DATETIME(6) DEFAULT NULL, created_at DATETIME(6) NOT NULL, updated_at DATETIME(6) NOT NULL, id CHAR(36) NOT NULL, todo_list_id CHAR(36) NOT NULL, INDEX IDX_17404CE7E8A7DCFA (todo_list_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('ALTER TABLE todo_list ADD CONSTRAINT FK_1B199E07A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE todo_list_item ADD CONSTRAINT FK_17404CE7E8A7DCFA FOREIGN KEY (todo_list_id) REFERENCES todo_list (id)');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE todo_list DROP FOREIGN KEY FK_1B199E07A76ED395');
        $this->addSql('ALTER TABLE todo_list_item DROP FOREIGN KEY FK_17404CE7E8A7DCFA');
        $this->addSql('DROP TABLE todo_list');
        $this->addSql('DROP TABLE todo_list_item');
    }
}
