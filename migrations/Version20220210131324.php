<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220210131324 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE category_tvshow (category_id INT NOT NULL, tvshow_id INT NOT NULL, INDEX IDX_4B41377D12469DE2 (category_id), INDEX IDX_4B41377D6CD43D7A (tvshow_id), PRIMARY KEY(category_id, tvshow_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE character_tvshow (character_id INT NOT NULL, tvshow_id INT NOT NULL, INDEX IDX_E7EB3E951136BE75 (character_id), INDEX IDX_E7EB3E956CD43D7A (tvshow_id), PRIMARY KEY(character_id, tvshow_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE category_tvshow ADD CONSTRAINT FK_4B41377D12469DE2 FOREIGN KEY (category_id) REFERENCES category (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE category_tvshow ADD CONSTRAINT FK_4B41377D6CD43D7A FOREIGN KEY (tvshow_id) REFERENCES tvshow (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE character_tvshow ADD CONSTRAINT FK_E7EB3E951136BE75 FOREIGN KEY (character_id) REFERENCES `character` (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE character_tvshow ADD CONSTRAINT FK_E7EB3E956CD43D7A FOREIGN KEY (tvshow_id) REFERENCES tvshow (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE episode ADD episodes_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE episode ADD CONSTRAINT FK_DDAA1CDA319135AF FOREIGN KEY (episodes_id) REFERENCES season (id)');
        $this->addSql('CREATE INDEX IDX_DDAA1CDA319135AF ON episode (episodes_id)');
        $this->addSql('ALTER TABLE season ADD seasons_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE season ADD CONSTRAINT FK_F0E45BA916EB9F66 FOREIGN KEY (seasons_id) REFERENCES tvshow (id)');
        $this->addSql('CREATE INDEX IDX_F0E45BA916EB9F66 ON season (seasons_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE category_tvshow');
        $this->addSql('DROP TABLE character_tvshow');
        $this->addSql('ALTER TABLE category CHANGE name name VARCHAR(50) NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE `character` CHANGE firstname firstname VARCHAR(50) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE lastname lastname VARCHAR(50) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE gender gender VARCHAR(25) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE bio bio LONGTEXT DEFAULT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE episode DROP FOREIGN KEY FK_DDAA1CDA319135AF');
        $this->addSql('DROP INDEX IDX_DDAA1CDA319135AF ON episode');
        $this->addSql('ALTER TABLE episode DROP episodes_id, CHANGE title title VARCHAR(50) NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE season DROP FOREIGN KEY FK_F0E45BA916EB9F66');
        $this->addSql('DROP INDEX IDX_F0E45BA916EB9F66 ON season');
        $this->addSql('ALTER TABLE season DROP seasons_id');
        $this->addSql('ALTER TABLE tvshow CHANGE title title VARCHAR(25) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE synopsis synopsis LONGTEXT DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE image image VARCHAR(255) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`');
    }
}
