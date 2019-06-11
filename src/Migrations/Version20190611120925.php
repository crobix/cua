<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190611120925 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf(
            $this->connection->getDatabasePlatform()->getName() !== 'mysql',
            'Migration can only be executed safely on \'mysql\'.'
        );

        $this->addSql(
            'CREATE TABLE security (id INT AUTO_INCREMENT NOT NULL, project_id VARCHAR(255) DEFAULT NULL, library VARCHAR(255) NOT NULL, library_version VARCHAR(10) NOT NULL, type VARCHAR(20) NOT NULL, comment TEXT DEFAULT NULL, link TEXT DEFAULT NULL, UNIQUE INDEX security_project_id_uindex (project_id), UNIQUE INDEX security_id_uindex (id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB'
        );
        $this->addSql(
            'CREATE TABLE dependencies (id INT AUTO_INCREMENT NOT NULL, project_id VARCHAR(255) DEFAULT NULL, library VARCHAR(255) DEFAULT \'NULL\', version VARCHAR(10) DEFAULT \'NULL\', state VARCHAR(50) DEFAULT \'NULL\', to_library VARCHAR(255) DEFAULT \'NULL\', to_version VARCHAR(255) DEFAULT \'NULL\', UNIQUE INDEX dependencies_project_id_uindex (project_id), UNIQUE INDEX dependencies_id_uindex (id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB'
        );
        $this->addSql(
            'CREATE TABLE project (id VARCHAR(255) NOT NULL, project_name VARCHAR(255) NOT NULL, php_version VARCHAR(10) DEFAULT \'NULL\', symfony_version VARCHAR(10) DEFAULT \'NULL\', path TEXT DEFAULT NULL, updated_at DATETIME NOT NULL, UNIQUE INDEX project_id_uindex (id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB'
        );
        $this->addSql(
            'ALTER TABLE security ADD CONSTRAINT FK_C59BD5C1166D1F9C FOREIGN KEY (project_id) REFERENCES project (id)'
        );
        $this->addSql(
            'ALTER TABLE dependencies ADD CONSTRAINT FK_EA0F708D166D1F9C FOREIGN KEY (project_id) REFERENCES project (id)'
        );
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf(
            $this->connection->getDatabasePlatform()->getName() !== 'mysql',
            'Migration can only be executed safely on \'mysql\'.'
        );

        $this->addSql('ALTER TABLE security DROP FOREIGN KEY FK_C59BD5C1166D1F9C');
        $this->addSql('ALTER TABLE dependencies DROP FOREIGN KEY FK_EA0F708D166D1F9C');
        $this->addSql('DROP TABLE security');
        $this->addSql('DROP TABLE dependencies');
        $this->addSql('DROP TABLE project');
    }
}
