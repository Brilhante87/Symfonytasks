<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230401095556 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE hobby (id INT AUTO_INCREMENT NOT NULL, designation VARCHAR(70) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE job (id INT AUTO_INCREMENT NOT NULL, designation VARCHAR(70) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE persone_hobby (persone_id INT NOT NULL, hobby_id INT NOT NULL, INDEX IDX_23EAD5017A9A1AEE (persone_id), INDEX IDX_23EAD501322B2123 (hobby_id), PRIMARY KEY(persone_id, hobby_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE profile (id INT AUTO_INCREMENT NOT NULL, url VARCHAR(255) NOT NULL, rs VARCHAR(70) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE persone_hobby ADD CONSTRAINT FK_23EAD5017A9A1AEE FOREIGN KEY (persone_id) REFERENCES persone (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE persone_hobby ADD CONSTRAINT FK_23EAD501322B2123 FOREIGN KEY (hobby_id) REFERENCES hobby (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE persone ADD profile_id INT DEFAULT NULL, ADD job_id INT DEFAULT NULL, DROP job');
        $this->addSql('ALTER TABLE persone ADD CONSTRAINT FK_56887282CCFA12B8 FOREIGN KEY (profile_id) REFERENCES profile (id)');
        $this->addSql('ALTER TABLE persone ADD CONSTRAINT FK_56887282BE04EA9 FOREIGN KEY (job_id) REFERENCES job (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_56887282CCFA12B8 ON persone (profile_id)');
        $this->addSql('CREATE INDEX IDX_56887282BE04EA9 ON persone (job_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE persone DROP FOREIGN KEY FK_56887282BE04EA9');
        $this->addSql('ALTER TABLE persone DROP FOREIGN KEY FK_56887282CCFA12B8');
        $this->addSql('ALTER TABLE persone_hobby DROP FOREIGN KEY FK_23EAD5017A9A1AEE');
        $this->addSql('ALTER TABLE persone_hobby DROP FOREIGN KEY FK_23EAD501322B2123');
        $this->addSql('DROP TABLE hobby');
        $this->addSql('DROP TABLE job');
        $this->addSql('DROP TABLE persone_hobby');
        $this->addSql('DROP TABLE profile');
        $this->addSql('DROP INDEX UNIQ_56887282CCFA12B8 ON persone');
        $this->addSql('DROP INDEX IDX_56887282BE04EA9 ON persone');
        $this->addSql('ALTER TABLE persone ADD job VARCHAR(50) DEFAULT NULL, DROP profile_id, DROP job_id');
    }
}
